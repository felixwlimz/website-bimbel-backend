<?php

namespace App\Services;

use App\Repositories\MaterialRepository;

class MateriServices
{
    public function __construct(
        protected MaterialRepository $materialRepo
    ) {}

    public function getByPackage(string $packageId)
    {
        return $this->materialRepo->findByPackage($packageId);
    }
}
