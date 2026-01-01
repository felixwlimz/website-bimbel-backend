<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\TransactionServices;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function __construct(
        protected TransactionServices $transactionServices
    ) {}

    /**
     * Handle Midtrans payment notification (webhook)
     * IMPORTANT:
     * - Tidak pakai auth
     * - Jangan expose ke user
     */
    public function handle(Request $request)
    {
        // Optional: validasi signature Midtrans (DISARANKAN)
        // $this->verifySignature($request);

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $transaction = Transaction::where(
            'invoice_number',
            $orderId
        )->first();

        if (! $transaction) {
            Log::warning('Midtrans webhook: transaction not found', [
                'order_id' => $orderId
            ]);

            return response()->json(['message' => 'Transaction not found'], 404);
        }

        /**
         * Status Midtrans:
         * settlement, capture → PAID
         * pending               → ignore
         * cancel, expire, deny  → FAILED (optional)
         */
        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $this->transactionServices->markPaid($transaction);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * (OPTIONAL) Signature verification
     * WAJIB di production
     */
    protected function verifySignature(Request $request): void
    {
        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            abort(403, 'Invalid Midtrans signature');
        }
    }
}
