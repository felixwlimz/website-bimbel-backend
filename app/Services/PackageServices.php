<?php

namespace App\Services;

use App\Repositories\PackageRepository;

class PackageServices
{
    public function __construct(
        protected PackageRepository $packageRepo
    ) {}

    /**
     * =========================
     * PUBLIC
     * =========================
     */
    public function getPublished()
    {
        return $this->packageRepo->getPublished();
    }

    public function show(string $id)
    {
        return $this->packageRepo->findById($id);
    }

    /**
     * =========================
     * ADMIN
     * =========================
     */
    public function getAll()
    {
        return $this->packageRepo->findAll();
    }

    public function create(array $data)
    {
        return $this->packageRepo->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->packageRepo->update($id, $data);
    }

    public function delete(string $id): void
    {
        $this->packageRepo->delete($id);
    }

    public function publish(string $id)
    {
        return $this->packageRepo->publish($id);
    }

    public function unpublish(string $id)
    {
        return $this->packageRepo->unpublish($id);
    }
}
