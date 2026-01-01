<?php

namespace App\Http\Controllers;

use App\Services\QuestionServices;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionServices $questionService
    ) {}

    public function byPackage(string $packageId)
    {
        return response()->json(
            $this->questionService->getByPackage($packageId)
        );
    }
}
