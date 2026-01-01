<?php

namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepository
{
    public function findByCode(string $code): ?Voucher
    {
        return Voucher::query()
            ->where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>', now());
            })
            ->first();
    }

    public function incrementUsage(Voucher $voucher): void
    {
        $voucher->increment('used_count');
    }
}
