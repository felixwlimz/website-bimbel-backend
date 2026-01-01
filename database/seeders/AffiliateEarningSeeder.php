<?php

namespace Database\Seeders;

use App\Models\AffiliateEarning;
use App\Models\Affiliate;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AffiliateEarningSeeder extends Seeder
{
    public function run(): void
    {
        AffiliateEarning::create([
            'id' => Str::uuid(),
            'affiliate_id' => Affiliate::first()->id,
            'transaction_id' => Transaction::first()->id,
            'commission_rate' => 10,
            'commission_amount' => 15000,
            'locked_until' => now()->addMonth(),
            'status' => 'locked',
        ]);
    }
}
