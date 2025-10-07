<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AnswerSheet;
use App\Models\Package;

class AnswerSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::factory()
            ->count(10)
            ->has(AnswerSheet::factory()->count(1))
            ->create();

    }
}
