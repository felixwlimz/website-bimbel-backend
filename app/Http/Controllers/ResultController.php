<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerSheetRepository;
use App\Repositories\SubTopicScoreRepository;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(
        protected AnswerSheetRepository $answerSheetRepo,
        protected SubTopicScoreRepository $subTopicScoreRepo
    ) {}

    /**
     * Get detailed result dengan breakdown per sub-topic
     */
    public function show(string $sheetId)
    {
        $sheet = $this->answerSheetRepo->findById($sheetId);

        // Verify ownership
        if ($sheet->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subTopicScores = $this->subTopicScoreRepo->getByAnswerSheet($sheetId);

        return response()->json([
            'answer_sheet' => [
                'id' => $sheet->id,
                'package_id' => $sheet->package_id,
                'total_score' => $sheet->total_score,
                'passing' => $sheet->passing,
                'submitted_at' => $sheet->submitted_at,
            ],
            'package' => [
                'title' => $sheet->package->title,
                'passing_grade' => $sheet->package->passing_grade,
            ],
            'sub_topic_scores' => $subTopicScores->map(fn ($score) => [
                'sub_topic_id' => $score->sub_topic_id,
                'sub_topic_name' => $score->subTopic->name,
                'total_questions' => $score->total_questions,
                'correct_answers' => $score->correct_answers,
                'total_score' => $score->total_score,
                'passing_grade' => $score->passing_grade,
                'is_passed' => $score->is_passed,
                'percentage' => $score->total_score > 0
                    ? round(($score->total_score / $score->total_score) * 100, 2)
                    : 0,
            ]),
        ]);
    }
}
