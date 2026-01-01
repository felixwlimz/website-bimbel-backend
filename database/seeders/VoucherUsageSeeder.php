<?php

namespace Database\Seeders;

use App\Models\VoucherUsage;
use App\Models\Voucher;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VoucherUsageSeeder extends Seeder
{
    public function run(): void
    {
        VoucherUsage::create([
            'id' => Str::uuid(),
            'voucher_id' => Voucher::first()->id,
            'user_id' => User::where('role', 'user')->first()->id,
            'transaction_id' => Transaction::first()->id,
            'used_at' => now(),
        ]);
    }
}
