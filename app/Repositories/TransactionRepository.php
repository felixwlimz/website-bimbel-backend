<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function findByInvoice(string $invoice)
    {
        return Transaction::query()
            ->with([
                'user:id,name,email',
                'package:id,title',
                'voucher:id,code',
                'affiliate.user:id,name',
            ])
            ->where('invoice_number', $invoice)
            ->firstOrFail();
    }

    public function findUserTransactions(string $userId)
    {
        return Transaction::query()
            ->with([
                'package:id,title,thumbnail',
            ])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }
}
