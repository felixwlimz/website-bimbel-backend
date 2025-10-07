<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::factory()
            ->has(
                Question::factory()
                    ->count(5)
                    ->hasOptions(4) // 4 opsi per soal
                    ->hasAnswers(1) // 1 jawaban benar
            )
            ->count(10)
            ->create();
    }
}
