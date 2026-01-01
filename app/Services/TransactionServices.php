<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\{
    TransactionRepository,
    VoucherRepository,
    VoucherUsageRepository
};
use Illuminate\Support\Facades\DB;

class TransactionServices
{
    public function __construct(
        protected TransactionRepository $transactionRepo,
        protected VoucherRepository $voucherRepo,
        protected VoucherUsageRepository $voucherUsageRepo
    ) {}

    /**
     * ============================
     * QUERY
     * ============================
     */

    /**
     * Riwayat transaksi user login
     */
    public function getUserHistory(string $userId)
    {
        return $this->transactionRepo->findUserTransactions($userId);
    }

    /**
     * Detail transaksi berdasarkan invoice
     */
    public function getByInvoice(string $invoice)
    {
        return $this->transactionRepo->findByInvoice($invoice);
    }

    /**
     * ============================
     * MUTATION
     * ============================
     */

    /**
     * HANYA dipanggil oleh webhook payment (Midtrans)
     */
    public function markPaid(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return $transaction;
        }

        return DB::transaction(function () use ($transaction) {

            $transaction->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            if ($transaction->voucher) {
                $this->voucherUsageRepo->create(
                    $transaction->voucher_id,
                    $transaction->user_id,
                    $transaction->id
                );

                $this->voucherRepo->incrementUsage($transaction->voucher);
            }

            return $transaction->fresh();
        });
    }
}
