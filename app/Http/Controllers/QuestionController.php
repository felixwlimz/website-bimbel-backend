<?php

namespace App\Http\Controllers;

use App\Services\SoalMateriServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    protected SoalMateriServices $soalMateriServices;

    public function __construct(SoalMateriServices $soalMateriServices)
    {
        $this->soalMateriServices = $soalMateriServices;
    }

    public function index(){
        $questions = $this->soalMateriServices->getAllQuestions();
        return response()->json([
            'message' => 'Questions retrieved successfully',
            'data' => $questions
        ], 200);
    }

    public function store(Request $request){
        $question = $this->soalMateriServices->addNewQuestion($request);
        return response()->json([
            'message' => 'Question added successfully',
            'data' => $question
        ], 201);
    }

    public function delete($id){
        $this->soalMateriServices->deleteQuestion($id);
        return response()->json([
            'message' => 'Question deleted successfully'
        ], 200);
    }
}
