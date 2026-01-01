<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Answer;
use App\Models\AnswerSheet;
use App\Models\Question;
use App\Models\Option;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Ambil answer sheet yang SUDAH ADA
         * (dibuat di AnswerSheetSeeder)
         */
        $answerSheet = AnswerSheet::first();

        if (! $answerSheet) {
            $this->command->warn('AnswerSeeder: No answer sheet found.');
            return;
        }

        /**
         * Ambil semua soal dalam paket
         */
        $questions = Question::where('package_id', $answerSheet->package_id)->get();

        foreach ($questions as $question) {

            // Pilih salah satu option (benar / salah random)
            $option = Option::where('question_id', $question->id)
                ->inRandomOrder()
                ->first();

            Answer::updateOrCreate(
                [
                    'answer_sheet_id' => $answerSheet->id,
                    'question_id'     => $question->id,
                ],
                [
                    'id'             => Str::uuid(),
                    'option_id'      => $option?->id,
                    'last_saved_at'  => now()->subSeconds(rand(5, 30)),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
        }

        $this->command->info('AnswerSeeder: Answers seeded successfully.');
    }
}
