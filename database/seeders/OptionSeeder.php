<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = Question::all();

        foreach ($questions as $q) {
            Option::insert([
                [
                    'id' => Str::uuid(),
                    'question_id' => $q->id,
                    'key' => 'A',
                    'content' => 'Jawaban A',
                    'score' => 10,
                    'is_correct' => true,
                    'order' => 1,
                ],
                [
                    'id' => Str::uuid(),
                    'question_id' => $q->id,
                    'key' => 'B',
                    'score' => 5,
                    'content' => 'Jawaban B',
                    'is_correct' => false,
                    'order' => 2,
                ],
            ]);
        }
    }
}
