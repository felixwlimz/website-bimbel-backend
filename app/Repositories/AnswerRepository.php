<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{
    public function save(string $sheetId, string $questionId, string $optionId): Answer
    {
        return Answer::updateOrCreate(
            [
                'answer_sheet_id' => $sheetId,
                'question_id' => $questionId,
            ],
            [
                'option_id' => $optionId,
                'last_saved_at' => now(),
            ]
        );
    }

    public function findBySheet(string $sheetId)
    {
        return Answer::query()
            ->with([
                'question:id,weight',
                'option:id,is_correct',
            ])
            ->where('answer_sheet_id', $sheetId)
            ->get();
    }
}
