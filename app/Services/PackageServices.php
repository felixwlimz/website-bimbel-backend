<?php

namespace App\Services;

use App\Repositories\PackageRepository;

class PackageServices
{
    protected PackageRepository $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function getAllPackages()
    {
        return $this->packageRepository->findAll();
    }

    public function getPackageById($id)
    {
        return $this->packageRepository->find($id);
    }

    public function createPackage(array $data)
    {
        return $this->packageRepository->create($data);
    }

    public function updatePackage($id, array $data)
    {
        return $this->packageRepository->update($id, $data);
    }

    public function deletePackage($id)
    {
        return $this->packageRepository->delete($id);
    }

    public function getPackageCategories()
    {
        return $this->packageRepository
            ->findAll()
            ->pluck('category')
            ->filter()            // buang null
            ->unique()
            ->values();
    }
}
