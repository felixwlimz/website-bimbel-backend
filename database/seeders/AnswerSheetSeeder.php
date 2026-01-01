<?php

namespace Database\Seeders;

use App\Models\AnswerSheet;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnswerSheetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        $package = Package::first();

        $sheet = AnswerSheet::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'status' => 'submitted',
            'started_at' => now()->subMinutes(90),
            'submitted_at' => now(),
            'total_score' => 80,
            'passing' => true,
        ]);

        foreach (Question::all() as $q) {
            Answer::create([
                'id' => Str::uuid(),
                'answer_sheet_id' => $sheet->id,
                'question_id' => $q->id,
                'option_id' => Option::where('question_id', $q->id)
                    ->where('is_correct', true)
                    ->first()->id,
                'last_saved_at' => now(),
            ]);
        }
    }
}
