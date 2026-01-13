<?php

namespace App\Services;

use App\Repositories\QuestionRepository;

class QuestionServices
{
    public function __construct(
        protected QuestionRepository $questionRepo
    ) {}

    /* =========================
     * GET
     * ========================= */

    /**
     * Ambil soal + options by package
     */
    public function getByPackage(string $packageId)
    {
        return $this->questionRepo->getByPackage($packageId);
    }

    /**
     * Ambil satu soal
     */
    public function find(string $id)
    {
        return $this->questionRepo->findById($id);
    }

    /* =========================
     * CREATE
     * ========================= */

    public function store(array $data)
    {
        return $this->questionRepo->create($data);
    }

    /* =========================
     * UPDATE
     * ========================= */

    public function update(string $id, array $data)
    {
        return $this->questionRepo->update($id, $data);
    }

    /* =========================
     * DELETE
     * ========================= */

    public function delete(string $id): void
    {
        $this->questionRepo->delete($id);
    }
}
