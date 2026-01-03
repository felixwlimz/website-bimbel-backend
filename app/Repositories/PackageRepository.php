<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Support\Str;

class PackageRepository
{
    /**
     * =========================
     * GET ALL (ADMIN)
     * =========================
     */
    public function findAll()
    {
        return Package::query()
            ->withCount(['materials', 'questions'])
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * =========================
     * GET PUBLISHED (PUBLIC)
     * =========================
     */
    public function getPublished()
    {
        return Package::query()
            ->where('status', 'published')
            ->withCount(['materials', 'questions'])
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * =========================
     * FIND BY ID
     * =========================
     */
    public function findById(string $id): Package
    {
        return Package::query()
            ->with([
                'materials:id,package_id,title,drive_link,access_type,order',
                'questions:id,package_id,title',
            ])
            ->findOrFail($id);
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create(array $data): Package
    {
        return Package::create([
            'id'               => Str::uuid(),
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'type'             => $data['type'],
            'price'            => $data['price'] ?? 0,
            'duration_minutes' => $data['duration_minutes'] ?? 0,
            'passing_grade'    => $data['passing_grade'] ?? null,
            'thumbnail'        => $data['thumbnail'] ?? null,
            'status'           => $data['status'] ?? 'draft',
            'created_by'       => auth()->id(),
        ]);
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(string $id, array $data): Package
    {
        $package = Package::findOrFail($id);

        $package->update([
            'title'            => $data['title']            ?? $package->title,
            'description'      => $data['description']      ?? $package->description,
            'type'             => $data['type']             ?? $package->type,
            'price'            => $data['price']            ?? $package->price,
            'duration_minutes' => $data['duration_minutes'] ?? $package->duration_minutes,
            'passing_grade'    => $data['passing_grade']    ?? $package->passing_grade,
            'thumbnail'        => $data['thumbnail']        ?? $package->thumbnail,
            'status'           => $data['status']           ?? $package->status,
        ]);

        return $package->fresh();
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete(string $id): void
    {
        Package::findOrFail($id)->delete();
    }

    /**
     * =========================
     * PUBLISH / UNPUBLISH
     * =========================
     */
    public function publish(string $id): Package
    {
        $package = Package::findOrFail($id);
        $package->update(['status' => 'published']);
        return $package->fresh();
    }

    public function unpublish(string $id): Package
    {
        $package = Package::findOrFail($id);
        $package->update(['status' => 'draft']);
        return $package->fresh();
    }
}
