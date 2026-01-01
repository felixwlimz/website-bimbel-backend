<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AffiliateSeeder::class,
            PackageSeeder::class,
            MaterialSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            VoucherSeeder::class,
            TransactionSeeder::class,
            VoucherUsageSeeder::class,
            AffiliateEarningSeeder::class,
            WithdrawalSeeder::class,
            AnswerSheetSeeder::class,
        ]);
    }
}
