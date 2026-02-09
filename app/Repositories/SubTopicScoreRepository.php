<?php

namespace App\Repositories;

use App\Models\SubTopicScore;
use Illuminate\Support\Str;

class SubTopicScoreRepository
{
    /**
     * Create or update sub topic score
     */
    public function createOrUpdate(array $data): SubTopicScore
    {
        return SubTopicScore::updateOrCreate(
            [
                'answer_sheet_id' => $data['answer_sheet_id'],
                'sub_topic_id' => $data['sub_topic_id'],
            ],
            [
                'total_questions' => $data['total_questions'],
                'correct_answers' => $data['correct_answers'],
                'total_score' => $data['total_score'],
                'passing_grade' => $data['passing_grade'],
                'is_passed' => $data['is_passed'],
            ]
        );
    }

    /**
     * Get all scores for an answer sheet
     */
    public function getByAnswerSheet(string $answerSheetId)
    {
        return SubTopicScore::query()
            ->where('answer_sheet_id', $answerSheetId)
            ->with('subTopic:id,name')
            ->get();
    }

    /**
     * Delete scores for an answer sheet
     */
    public function deleteByAnswerSheet(string $answerSheetId): void
    {
        SubTopicScore::where('answer_sheet_id', $answerSheetId)->delete();
    }
}
