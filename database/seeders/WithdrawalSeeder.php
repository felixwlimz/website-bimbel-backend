<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::factory()
           ->count(10)
           ->has(Withdrawal::factory()->count(2))
           ->create();
    }
}
