<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()
            ->has(Voucher::factory()->count(10))
            ->count(10)
            ->create();
    }
}
