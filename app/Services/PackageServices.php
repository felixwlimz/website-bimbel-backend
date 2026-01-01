<?php

namespace App\Services;

use App\Repositories\PackageRepository;

class PackageServices
{
    public function __construct(
        protected PackageRepository $packageRepo
    ) {}

    public function getPublished()
    {
        return $this->packageRepo->getPublished();
    }

    public function getById(string $id)
    {
        return $this->packageRepo->findById($id);
    }
}
