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

    public function markPaid(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return $transaction;
        }

        return DB::transaction(function () use ($transaction) {

            $transaction->update([
                'status' => 'paid',
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
