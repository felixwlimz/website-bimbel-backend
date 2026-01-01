<?php

namespace App\Http\Controllers;

use App\Services\AnswerServices;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct(
        protected AnswerServices $answerServices
    ) {}

    /**
     * Autosave jawaban (dipanggil berkala dari frontend)
     */
    public function autosave(Request $request)
    {
        $request->validate([
            'answer_sheet_id' => ['required', 'uuid'],
            'question_id'     => ['required', 'uuid'],
            'option_id'       => ['required', 'uuid'],
        ]);

        return response()->json(
            $this->answerServices->autosave(
                $request->answer_sheet_id,
                $request->question_id,
                $request->option_id
            )
        );
    }

    /**
     * Ambil semua jawaban dalam satu answer sheet
     */
    public function bySheet(string $sheetId)
    {
        return response()->json(
            $this->answerServices->getBySheet($sheetId)
        );
    }
}
