<?php

namespace App\Repositories;

use App\Models\Material;

class MaterialRepository
{
    /**
     * Get all materials (admin)
     */
    public function getAll()
    {
        return Material::with('package')
            ->orderBy('order')
            ->get();
    }

    /**
     * Get materials by package (user access)
     */
    public function findByPackage(string $packageId)
    {
        return Material::query()
            ->where('package_id', $packageId)
            ->orderBy('order')
            ->get();
    }

    /**
     * Find material by id
     */
    public function findById(string $id): Material
    {
        return Material::findOrFail($id);
    }

    /**
     * Create material
     */
    public function create(array $data): Material
    {
        return Material::create($data);
    }

    /**
     * Update material
     */
    public function update(string $id, array $data): Material
    {
        $material = $this->findById($id);
        $material->update($data);
        return $material;
    }

    /**
     * Delete material
     */
    public function delete(string $id): void
    {
        $material = $this->findById($id);
        $material->delete();
    }
}
