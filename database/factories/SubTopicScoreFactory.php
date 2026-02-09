<?php

namespace Database\Factories;

use App\Models\AnswerSheet;
use App\Models\SubTopic;
use App\Models\SubTopicScore;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubTopicScoreFactory extends Factory
{
    protected $model = SubTopicScore::class;

    public function definition(): array
    {
        $totalQuestions = $this->faker->numberBetween(5, 20);
        $correctAnswers = $this->faker->numberBetween(0, $totalQuestions);
        $totalScore = $correctAnswers;
        $passingGrade = 70;

        return [
            'id' => Str::uuid(),
            'answer_sheet_id' => AnswerSheet::factory(),
            'sub_topic_id' => SubTopic::factory(),
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'total_score' => $totalScore,
            'passing_grade' => $passingGrade,
            'is_passed' => ($totalScore / $totalQuestions * 100) >= $passingGrade,
        ];
    }
}
