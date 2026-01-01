<?php

namespace App\Repositories;

use App\Models\VoucherUsage;
use Illuminate\Support\Str;

class VoucherUsageRepository
{
    public function create(string $voucherId, string $userId, string $transactionId)
    {
        return VoucherUsage::create([
            'id' => Str::uuid(),
            'voucher_id' => $voucherId,
            'user_id' => $userId,
            'transaction_id' => $transactionId,
            'used_at' => now(),
        ]);
    }
}
