<?php

namespace App\Repositories;

use App\Models\Package;

class PackageRepository
{
    public function getPublished()
    {
        return Package::query()
            ->where('status', 'published')
            ->withCount(['questions', 'materials'])
            ->get();
    }

    public function findById(string $id): Package
    {
        return Package::query()
            ->with([
                'materials:id,package_id,title,drive_link,access_type,order',
                'questions:id,package_id,title',
            ])
            ->findOrFail($id);
    }
}
