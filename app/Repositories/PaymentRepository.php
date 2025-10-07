<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;
use Illuminate\Support\Str;

class PaymentRepository
{

    protected TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createCharge(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1000',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'voucher_id' => $request->voucher_id ?? null,
            'payment_method' => 'midtrans',
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount' => $request->amount,
            'discount_amount' => $request->discount_amount ?? 0,
            'status' => 'pending',
        ]);

        // Kirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_number,
                'gross_amount' => $validated['amount'] - $validated['discount_amount'],
            ],
            'customer_details' => [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // ✅ Update snap_token di DB
        $transaction->update([
            'snap_token' => $snapToken,
        ]);

        return response()->json([
            'snap_token' => $snapToken,
            'transaction' => $transaction
        ]);
    }
}
