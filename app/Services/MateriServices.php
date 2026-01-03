<?php

namespace App\Services;

use App\Repositories\MaterialRepository;
use Illuminate\Support\Str;

class MateriServices
{
    public function __construct(
        protected MaterialRepository $materialRepo
    ) {}

    /**
     * Admin: get all materials
     */
    public function getAll()
    {
        return $this->materialRepo->getAll();
    }

    /**
     * User/Admin: get materials by package
     */
    public function getByPackage(string $packageId)
    {
        return $this->materialRepo->findByPackage($packageId);
    }

    /**
     * Admin: create material
     */
    public function create(array $data)
    {
        return $this->materialRepo->create([
            'id'         => Str::uuid(),
            'package_id' => $data['package_id'],
            'title'      => $data['title'],
            'drive_link' => $data['drive_link'],
            'preview'    => $data['preview'] ?? false,
            'order'      => $data['order'] ?? 0,
        ]);
    }

    /**
     * Admin: update material
     */
    public function update(string $id, array $data)
    {
        return $this->materialRepo->update($id, $data);
    }

    /**
     * Admin: delete material
     */
    public function delete(string $id)
    {
        $this->materialRepo->delete($id);
    }
}
