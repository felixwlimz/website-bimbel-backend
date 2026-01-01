<?php

namespace App\Services;

use App\Repositories\AnswerSheetRepository;
use Illuminate\Support\Facades\DB;

class AnswerSheetServices
{
    public function __construct(
        protected AnswerSheetRepository $answerSheetRepo
    ) {}

    /**
     * ============================
     * QUERY
     * ============================
     */

    /**
     * Ambil answer sheet aktif
     */
    public function getActive(string $userId, string $packageId)
    {
        return $this->answerSheetRepo->findActive($userId, $packageId);
    }

    /**
     * ============================
     * MUTATION
     * ============================
     */

    /**
     * Start tryout:
     * - Jika sudah ada answer sheet, return existing
     * - Jika belum, buat baru
     */
    public function start(string $userId, string $packageId)
    {
        return DB::transaction(function () use ($userId, $packageId) {

            $existing = $this->answerSheetRepo->findActive($userId, $packageId);

            if ($existing) {
                return $existing;
            }

            return $this->answerSheetRepo->create([
                'user_id'     => $userId,
                'package_id'  => $packageId,
                'total_score' => 0,
                'passing'     => false,
            ]);
        });
    }

    /**
     * Submit tryout (final)
     * NOTE: scoring logic bisa dipanggil sebelum method ini
     */
    public function submit(string $sheetId, int $totalScore, bool $passing)
    {
        return DB::transaction(function () use ($sheetId, $totalScore, $passing) {

            $sheet = $this->answerSheetRepo->findById($sheetId);

            return $this->answerSheetRepo->updateResult(
                $sheet,
                $totalScore,
                $passing
            );
        });
    }
}
