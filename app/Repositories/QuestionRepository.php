<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{

    public function findAll()
    {
        return Question::with(['package', 'options', 'answers'])->get();
    }

    public function create(array $data)
    {

      return Question::create($data);
    }

    public function update($id, $data)
    {
        $question = Question::with('package')->findOrFail($id);
        $question->update($data);
        return $question;
    }

    public function find($id)
    {
        return Question::with(['package', 'options'])->findOrFail($id);
    }
}
