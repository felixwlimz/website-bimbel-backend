<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository
{
    /* =========================
     * GET
     * ========================= */

    /**
     * Ambil semua soal berdasarkan package
     */
    public function getByPackage(string $packageId): Collection
    {
        return Question::where('package_id', $packageId)->get();
    }

    /**
     * Ambil satu soal by ID
     */
    public function findById(string $id): ?Question
    {
        return Question::with([
            'options:id,question_id,key,content,order',
        ])->find($id);
    }

    /* =========================
     * CREATE
     * ========================= */

    /**
     * Buat soal baru
     */
    public function create(array $data): Question
    {
        return Question::create([
            'package_id'     => $data['package_id'],
            'title'         => $data['title'],
            'media_type'           => $data['media_type'], // text / image / video
            'content'        => $data['content'],
            'media_url'      => $data['media_url'] ?? null,
            'weight'         => $data['weight'] ?? 1,
            'order'          => $data['order'] ?? 0,
        ]);
    }

    /* =========================
     * UPDATE
     * ========================= */

    /**
     * Update soal
     */
    public function update(string $id, array $data): Question
    {
        $question = Question::findOrFail($id);

        $question->update([
            'title'         => $data['title']         ?? $question->title,
            'media_type'           => $data['media_type']           ?? $question->media_type,
            'content'        => $data['content']        ?? $question->content,
            'media_url'      => $data['media_url']      ?? $question->media_url,
            'weight'         => $data['weight']         ?? $question->weight,
            'order'          => $data['order']          ?? $question->order,
        ]);

        return $question;
    }

    /* =========================
     * DELETE
     * ========================= */

    /**
     * Hapus soal + options
     */
    public function delete(string $id): void
    {
        $question = Question::findOrFail($id);

        // hapus opsi jawaban dulu
        $question->options()->delete();

        $question->delete();
    }

    /* =========================
     * UTILS
     * ========================= */

    /**
     * Hitung jumlah soal per package
     */
    public function countByPackage(string $packageId): int
    {
        return Question::where('package_id', $packageId)->count();
    }
}
