<?php

namespace App\Http\Controllers;

use App\Services\PackageSetService;
use Illuminate\Http\Request;

class PackageSetController extends Controller
{
    public function __construct(
        protected PackageSetService $packageSetService
    ) {}

    /**
     * Get all question sets dalam package
     * Contoh: GET /packages/{packageId}/sets
     */
    public function index(string $packageId)
    {
        return response()->json(
            $this->packageSetService->getQuestionSets($packageId)
        );
    }

    /**
     * Get package summary (berapa sets, total soal)
     * Contoh: GET /packages/{packageId}/summary
     */
    public function summary(string $packageId)
    {
        return response()->json(
            $this->packageSetService->getPackageSummary($packageId)
        );
    }

    /**
     * Create new question set
     * Contoh: POST /packages/{packageId}/sets
     * Body: { "name": "Aljabar" }
     */
    public function store(Request $request, string $packageId)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $set = $this->packageSetService->createQuestionSet(
            $packageId,
            $request->name
        );

        return response()->json($set, 201);
    }

    /**
     * Add questions ke specific set
     * Contoh: POST /sets/{setId}/questions
     * Body: {
     *   "questions": [
     *     {
     *       "title": "Soal 1",
     *       "content": "Isi soal",
     *       "weight": 1,
     *       "options": [
     *         { "key": "A", "content": "Pilihan A", "is_correct": true, "score": 1 }
     *       ]
     *     }
     *   ]
     * }
     */
    public function addQuestions(Request $request, string $setId)
    {
        $request->validate([
            'questions' => ['required', 'array'],
            'questions.*.title' => ['required', 'string'],
            'questions.*.content' => ['required', 'string'],
            'questions.*.weight' => ['integer', 'min:1'],
            'questions.*.options' => ['required', 'array'],
        ]);

        $this->packageSetService->addQuestionsToSet(
            $setId,
            $request->questions
        );

        return response()->json(['message' => 'Questions added successfully'], 201);
    }
}
