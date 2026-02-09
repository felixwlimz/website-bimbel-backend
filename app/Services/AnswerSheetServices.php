<?php

namespace App\Services;

use App\Repositories\AnswerSheetRepository;
use App\Repositories\SubTopicScoreRepository;
use Illuminate\Support\Facades\DB;

class AnswerSheetServices
{
    public function __construct(
        protected AnswerSheetRepository $answerSheetRepo,
        protected SubTopicScoreRepository $subTopicScoreRepo,
        protected ScoringService $scoringService,
        protected NotificationServices $notificationServices
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
     * Submit tryout dengan scoring per sub-topic
     */
    public function submit(string $sheetId, int $totalScore, bool $passing)
    {
        return DB::transaction(function () use ($sheetId, $totalScore, $passing) {

            $sheet = $this->answerSheetRepo->findById($sheetId);

            // Calculate scores per sub-topic
            $scoreData = $this->scoringService->calculateScores($sheet);

            // Save sub-topic scores
            $this->scoringService->saveSubTopicScores($sheet, $scoreData);

            // Update answer sheet with overall score
            $updatedSheet = $this->answerSheetRepo->updateResult(
                $sheet,
                $scoreData['total_score'],
                $scoreData['is_passed']
            );

            // Send notification with detailed breakdown
            $this->sendResultNotification($updatedSheet, $scoreData);

            return $updatedSheet;
        });
    }

    /**
     * Send notification dengan breakdown per sub-topic
     */
    private function sendResultNotification(object $sheet, array $scoreData): void
    {
        $user = $sheet->user;
        $package = $sheet->package;

        // Build message dengan breakdown per sub-topic
        $subTopicBreakdown = collect($scoreData['sub_topic_scores'])
            ->map(fn ($score) => sprintf(
                "%s: %d/%d (%d%%) %s",
                $score['sub_topic_name'],
                $score['correct_answers'],
                $score['total_questions'],
                $score['percentage'],
                $score['is_passed'] ? '✓' : '✗'
            ))
            ->join("\n");

        $message = sprintf(
            "Hasil Ujian: %s\n\nNilai Akhir: %d%% (Passing Grade: %d%%)\n\nBreakdown Per Sub Bab:\n%s",
            $package->title,
            $scoreData['overall_percentage'],
            $scoreData['passing_grade'],
            $subTopicBreakdown
        );

        $this->notificationServices->notifyUser(
            $user->id,
            $scoreData['is_passed'] ? 'Selamat! Anda Lulus' : 'Hasil Ujian Tersedia',
            $message,
            $scoreData['is_passed'] ? 'success' : 'info',
            "/dashboard/results/{$sheet->id}"
        );
    }
}
