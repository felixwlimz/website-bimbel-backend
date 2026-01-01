<?php

namespace Database\Seeders;

use App\Models\Withdrawal;
use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        Withdrawal::create([
            'id' => Str::uuid(),
            'affiliate_id' => Affiliate::first()->id,
            'amount' => 15000,
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'Affiliate Test',
            'status' => 'approved',
            'approved_by' => User::where('role', 'super_admin')->first()->id,
            'approved_at' => now(),
        ]);
    }
}
