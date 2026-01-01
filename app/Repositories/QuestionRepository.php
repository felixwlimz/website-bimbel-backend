<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    public function getByPackage(string $packageId)
    {
        return Question::query()
            ->with([
                'options:id,question_id,key,content,order',
            ])
            ->where('package_id', $packageId)
            ->orderBy('id')
            ->get();
    }
}
