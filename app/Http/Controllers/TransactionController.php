<?php

namespace App\Http\Controllers;

use App\Services\TransactionServices;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServices $transactionService
    ) {}

    public function history()
    {
        return response()->json(
            $this->transactionService->getUserHistory(auth()->id())
        );
    }

    public function show(string $invoice)
    {
        return response()->json(
            $this->transactionService->getByInvoice($invoice)
        );
    }
}
