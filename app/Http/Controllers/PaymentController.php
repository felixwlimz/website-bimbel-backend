<?php

namespace App\Http\Controllers;

use Midtrans\Notification;
use App\Services\PembayaranServices;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Log;


class PaymentController extends Controller
{

    protected PembayaranServices $pembayaranServices;


    public function __construct(PembayaranServices $pembayaranServices)
    {
        $this->pembayaranServices = $pembayaranServices;



        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }


    public function createPayment(Request $request)
{
    $orderId = uniqid("INV-"); // your invoice id
    $amount = $request->amount;

    $transaction = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $amount,
        ],
        'customer_details' => [
            'first_name' => 'Test User',
            'email' => 'test@example.com',
        ],
    ];

    $snapToken = Snap::getSnapToken($transaction);

    // $this->pembayaranServices->createTransaction([
    //     'user_id' => auth()->id(),
    //     'package_id' => $request->package_id,
    //     'voucher_id' => $request->voucher_id,
    //     'payment_method' => $request->payment_method,
    //     'invoice_number' => $orderId,
    //     'amount' => $amount,
    //     'discount_amount' => 0,
    //     'status' => 'pending',
    //     'midtrans_order_id' => $orderId,
    // ]);

    // save to DB if needed
    return response()->json(['snapToken' => $snapToken, 'order_id' => $orderId]);
}



    public function notification(Request $request)
    {


        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;


            $transaction = $this->pembayaranServices->getMidtransOrderId($orderId);

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            switch ($transactionStatus) {
                case 'capture':
                    $transaction->status = ($fraudStatus == 'challenge') ? 'pending' : 'success';
                    break;
                case 'settlement':
                    $transaction->status = 'success';
                    break;
                case 'pending':
                    $transaction->status = 'pending';
                    break;
                case 'deny':
                    $transaction->status = 'failed';
                    break;
            }

            $transaction->save();
            return response()->json(['message' => 'Transaction updated']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Notification handling failed',
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ], 500);
        }
    }
}
