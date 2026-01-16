<?php

namespace App\Http\Controllers;

use App\Services\QuestionServices;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionServices $questionService
    ) {}

    /**
     * ============================
     * GET QUESTIONS BY PACKAGE
     * ============================
     */
    public function byPackage(string $packageId)
    {
        return response()->json([
            'message' => 'Questions retrieved successfully',
            'data' => $this->questionService->getByPackage($packageId),
        ]);
    }

    /**
     * ============================
     * CREATE QUESTION
     * ============================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'   => 'required|uuid|exists:packages,id',

            // content
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',

            // media
            'media_type'   => 'required|in:none,image,audio,video',
            'media_path'   => 'nullable|string',

            // scoring
            'weight'       => 'required|integer|min:1',
            'score' => 'required|integer|min:0',

            // classification
            'sub_topic_id' => 'nullable|uuid',

            'explanation'  => 'nullable|string',
        ]);

        $question = $this->questionService->store($validated);

        return response()->json([
            'message' => 'Question created successfully',
            'data' => $question,
        ], 201);
    }

    /**
     * ============================
     * UPDATE QUESTION
     * ============================
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'content'      => 'sometimes|required|string',

            'media_type'   => 'sometimes|required|in:none,image,audio,video',
            'media_path'   => 'nullable|string',

            'weight'       => 'sometimes|required|integer|min:1',
            'sub_topic_id' => 'nullable|uuid',
            'explanation'  => 'nullable|string',
        ]);

        $question = $this->questionService->update($id, $validated);

        return response()->json([
            'message' => 'Question updated successfully',
            'data' => $question,
        ]);
    }

    /**
     * ============================
     * DELETE QUESTION
     * ============================
     */
    public function delete(string $id)
    {
        $this->questionService->delete($id);

        return response()->json([
            'message' => 'Question deleted successfully',
        ]);
    }
}
