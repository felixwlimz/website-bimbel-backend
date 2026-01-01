<?php

namespace App\Repositories;

use App\Models\Material;

class MaterialRepository
{
    public function findByPackage(string $packageId)
    {
        return Material::query()
            ->where('package_id', $packageId)
            ->orderBy('order')
            ->get();
    }
}
