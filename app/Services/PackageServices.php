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


    public function createPackage(array $data){
        return $this->packageRepository->create($data);
    }
}