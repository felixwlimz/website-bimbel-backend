<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Withdrawal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()
        ->has(Affiliate::factory()->count(3), 'affiliate') // each user will have 3 affiliates
        ->has(Withdrawal::factory()->count(2), 'withdrawals') // each user will have 2 withdrawals
        ->has(Voucher::factory()->count(5), 'vouchers') // each user will have 5 vouchers
        ->count(10)->create();
    }
}
