<?php

namespace App\Http\Controllers;

use App\Services\AnswerSheetServices;
use Illuminate\Http\Request;

class AnswerSheetController extends Controller
{
    public function __construct(
        protected AnswerSheetServices $answerSheetServices
    ) {}

    /**
     * Start tryout (create answer sheet)
     */
    public function start(Request $request, string $packageId)
    {
        return response()->json(
            $this->answerSheetServices->start(
                $request->user()->id,
                $packageId
            ),
            201
        );
    }

    /**
     * Ambil answer sheet aktif user (optional)
     */
    public function active(Request $request, string $packageId)
    {
        return response()->json(
            $this->answerSheetServices->getActive(
                $request->user()->id,
                $packageId
            )
        );
    }

    /**
     * Submit tryout (finalize)
     * Biasanya dipanggil setelah scoring selesai
     */
    public function submit(Request $request, string $sheetId)
    {
        return response()->json(
            $this->answerSheetServices->submit(
                $sheetId,
                $request->integer('total_score'),
                $request->boolean('passing')
            )
        );
    }
}
