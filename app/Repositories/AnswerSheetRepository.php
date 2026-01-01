<?php

namespace App\Repositories;

use App\Models\AnswerSheet;

class AnswerSheetRepository
{
    /**
     * Ambil answer sheet aktif user untuk paket tertentu
     */
    public function findActive(string $userId, string $packageId): ?AnswerSheet
    {
        return AnswerSheet::query()
            ->where('user_id', $userId)
            ->where('package_id', $packageId)
            ->latest()
            ->first();
    }

    /**
     * Ambil answer sheet by ID
     */
    public function findById(string $id): AnswerSheet
    {
        return AnswerSheet::findOrFail($id);
    }

    /**
     * Buat answer sheet baru (start tryout)
     */
    public function create(array $data): AnswerSheet
    {
        return AnswerSheet::create($data);
    }

    /**
     * Update hasil akhir tryout
     */
    public function updateResult(
        AnswerSheet $sheet,
        int $totalScore,
        bool $passing
    ): AnswerSheet {
        $sheet->update([
            'total_score' => $totalScore,
            'passing'     => $passing,
        ]);

        return $sheet->fresh();
    }
}
