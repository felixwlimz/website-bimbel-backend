<?php

namespace App\Services;

use App\Repositories\AnswerRepository;
use Illuminate\Support\Facades\DB;

class AnswerServices
{
    public function __construct(
        protected AnswerRepository $answerRepo
    ) {}

    /**
     * ============================
     * QUERY
     * ============================
     */

    /**
     * Ambil semua jawaban dalam satu answer sheet
     */
    public function getBySheet(string $answerSheetId)
    {
        return $this->answerRepo->findBySheet($answerSheetId);
    }

    /**
     * ============================
     * MUTATION
     * ============================
     */

    /**
     * Autosave jawaban
     * - Dipanggil tiap beberapa detik
     * - Idempotent (di-handle di repository)
     */
    public function autosave(
        string $answerSheetId,
        string $questionId,
        string $optionId
    ) {
        return DB::transaction(function () use (
            $answerSheetId,
            $questionId,
            $optionId
        ) {
            return $this->answerRepo->save(
                $answerSheetId,
                $questionId,
                $optionId
            );
        });
    }
}
