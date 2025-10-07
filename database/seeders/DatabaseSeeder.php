<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Withdrawal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            PackageSeeder::class,
            VoucherSeeder::class,
            QuestionSeeder::class,
            TransactionSeeder::class,
            MaterialSeeder::class,
            AffiliateSeeder::class,
            AnswerSheetSeeder::class,
            AnswerSeeder::class,
            AffiliateEarningsSeeder::class,
            WithdrawalSeeder::class
        ]);
    }
}
