<?php

namespace App\Services;

use App\Models\AnswerSheet;
use App\Models\SubTopic;
use App\Repositories\SubTopicScoreRepository;
use Illuminate\Support\Facades\DB;

class ScoringService
{
    public function __construct(
        protected SubTopicScoreRepository $subTopicScoreRepo
    ) {}

    /**
     * Calculate scores per sub-topic
     * Returns array with per-subtopic breakdown and overall score
     */
    public function calculateScores(AnswerSheet $answerSheet): array
    {
        $answers = $answerSheet->answers()
            ->with([
                'question:id,sub_topic_id,weight',
                'option:id,is_correct,score',
            ])
            ->get();

        $package = $answerSheet->package;
        $subTopics = SubTopic::where('package_id', $package->id)
            ->with('questions:id,sub_topic_id,weight')
            ->get();

        $subTopicScores = [];
        $totalScore = 0;
        $totalWeight = 0;

        // Calculate per sub-topic
        foreach ($subTopics as $subTopic) {
            $subTopicAnswers = $answers->filter(
                fn ($a) => $a->question->sub_topic_id === $subTopic->id
            );

            $correctCount = $subTopicAnswers->filter(
                fn ($a) => $a->option->is_correct
            )->count();

            $subTopicWeight = $subTopic->questions->sum('weight');
            $subTopicScore = $subTopicAnswers
                ->filter(fn ($a) => $a->option->is_correct)
                ->sum(fn ($a) => $a->question->weight);

            $subTopicPercentage = $subTopicWeight > 0
                ? ($subTopicScore / $subTopicWeight) * 100
                : 0;

            $isPassed = $subTopicPercentage >= ($package->passing_grade ?? 0);

            $subTopicScores[] = [
                'sub_topic_id' => $subTopic->id,
                'sub_topic_name' => $subTopic->name,
                'total_questions' => $subTopicAnswers->count(),
                'correct_answers' => $correctCount,
                'total_score' => $subTopicScore,
                'total_weight' => $subTopicWeight,
                'percentage' => round($subTopicPercentage, 2),
                'passing_grade' => $package->passing_grade ?? 0,
                'is_passed' => $isPassed,
            ];

            $totalScore += $subTopicScore;
            $totalWeight += $subTopicWeight;
        }

        $overallPercentage = $totalWeight > 0
            ? ($totalScore / $totalWeight) * 100
            : 0;

        $overallPassing = $overallPercentage >= ($package->passing_grade ?? 0);

        return [
            'sub_topic_scores' => $subTopicScores,
            'total_score' => $totalScore,
            'total_weight' => $totalWeight,
            'overall_percentage' => round($overallPercentage, 2),
            'passing_grade' => $package->passing_grade ?? 0,
            'is_passed' => $overallPassing,
        ];
    }

    /**
     * Save sub-topic scores to database
     */
    public function saveSubTopicScores(AnswerSheet $answerSheet, array $scoreData): void
    {
        DB::transaction(function () use ($answerSheet, $scoreData) {
            // Clear existing scores
            $this->subTopicScoreRepo->deleteByAnswerSheet($answerSheet->id);

            // Save new scores
            foreach ($scoreData['sub_topic_scores'] as $score) {
                $this->subTopicScoreRepo->createOrUpdate([
                    'answer_sheet_id' => $answerSheet->id,
                    'sub_topic_id' => $score['sub_topic_id'],
                    'total_questions' => $score['total_questions'],
                    'correct_answers' => $score['correct_answers'],
                    'total_score' => $score['total_score'],
                    'passing_grade' => $score['passing_grade'],
                    'is_passed' => $score['is_passed'],
                ]);
            }
        });
    }
}
