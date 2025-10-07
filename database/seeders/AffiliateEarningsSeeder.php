<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\AffiliateEarnings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AffiliateEarningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AffiliateEarnings::factory()->count(10)->create();
    }
}
