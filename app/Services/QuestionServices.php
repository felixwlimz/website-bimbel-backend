<?php

namespace App\Services;

use App\Repositories\QuestionRepository;

class QuestionServices
{
    public function __construct(
        protected QuestionRepository $questionRepo
    ) {}

    /**
     * Ambil soal + options (anti N+1 dari repo)
     */
    public function getByPackage(string $packageId)
    {
        return $this->questionRepo->getByPackage($packageId);
    }
}
