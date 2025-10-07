<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::factory()
            ->count(10)
            ->has(Answer::factory()->count(4))
            ->create();

    }
}
