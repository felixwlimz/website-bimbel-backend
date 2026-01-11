<?php 

namespace App\Services;

use App\Models\Package;
use App\Repositories\PaymentRepository;
use App\Repositories\TransactionRepository;
use App\Services\VoucherServices;
use Illuminate\Support\Str;

class PaymentServices
{
    public function __construct(
        protected PaymentRepository $paymentRepo,
        protected TransactionRepository $transactionRepo,
        protected VoucherServices $voucherService
    ) {}

    public function createPayment(array $data)
    {
        $user = auth()->user();

        $package = Package::findOrFail($data['package_id']);

        // ✅ HITUNG HARGA DARI DB
        $price = $package->price;
        $discount = 0;
        $voucherId = null;

        if (!empty($data['voucher_code'])) {
            $voucher = $this->voucherService->validateVoucher($data['voucher_code']);
            $discount = $voucher->discount_amount;
            $voucherId = $voucher->id;
        }

        // ✅ CREATE TRANSACTION
        // Fix: Manually generate the UUID for the 'id' column
        $transaction = $this->transactionRepo->create([
            'id' => (string) Str::uuid(), // <--- ADDED THIS LINE
            'user_id' => $user->id,
            'package_id' => $package->id,
            'voucher_id' => $voucherId,
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'amount' => $price,
            'original_amount' => $price,
            'discount_amount' => $discount,
            'final_amount' => max($price - $discount, 0),
            'payment_method' => 'midtrans',
            'status' => 'pending',
        ]);

        // ✅ CREATE SNAP TOKEN
        $snapToken = $this->paymentRepo->createMidtransSnap($transaction);

        $transaction->update([
            'snap_token' => $snapToken
        ]);

        return [
            'snap_token' => $snapToken,
            'transaction_id' => $transaction->id,
        ];
    }
}