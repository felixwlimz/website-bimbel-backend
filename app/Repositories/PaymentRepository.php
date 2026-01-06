<?php
namespace App\Repositories;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;

class PaymentRepository
{
    public function __construct()
    {
        Config::$serverKey     = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createMidtransSnap(Transaction $transaction): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_number,
                'gross_amount' => $transaction->final_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email'      => $transaction->user->email,
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
