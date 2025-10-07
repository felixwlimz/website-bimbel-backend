<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
        ->has(Affiliate::factory()->count(5))
        ->count(5)
        ->create();
    }
}
