<?php

namespace App\Repositories;

use App\Models\LandingPage;
use Illuminate\Support\Str;

class LandingPageRepository
{

    public function getPublished()
    {
        return LandingPage::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->get([
                'id',
                'title',
                'slug',
                'description',
                'image_path',
                'type',
                'order',
            ]);
    }


    public function findPublishedBySlug(string $slug): ?LandingPage
    {
        return LandingPage::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
    }

    public function getAll()
    {
        return LandingPage::query()
            ->with([
                'creator:id,name,email',
            ])
            ->orderBy('order')
            ->get();
    }


    public function findById(string $id): LandingPage
    {
        return LandingPage::query()
            ->with('creator:id,name,email')
            ->findOrFail($id);
    }


    public function create(array $data): LandingPage
    {
        return LandingPage::create([
            'title'       => $data['title'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
            'image_path'  => $data['image_path'] ?? null,
            'type'        => $data['type'],
            'order'       => $data['order'] ?? 0,
            'status'      => $data['status'],
            'created_by'  => auth()->id(),
        ]);
    }

    /**
     * Update landing page content
     */
     public function update(string $id, array $data): LandingPage
    {
        $page = LandingPage::findOrFail($id);

        $page->update([
            'title'       => $data['title']       ?? $page->title,
            'slug'        => $data['slug']        ?? $page->slug,
            'description' => $data['description'] ?? $page->description,
            'image_path'  => $data['image_path']  ?? $page->image_path,
            'type'        => $data['type']        ?? $page->type,
            'order'       => $data['order']       ?? $page->order,
            'status'      => $data['status']      ?? $page->status,
        ]);

        return $page;
    }

    public function publish(LandingPage $page): LandingPage
    {
        $page->update([
            'status' => 'published',
        ]);

        return $page->fresh();
    }

    /**
     * Unpublish landing page (kembali ke draft)
     */
    public function unpublish(LandingPage $page): LandingPage
    {
        $page->update([
            'status' => 'draft',
        ]);

        return $page->fresh();
    }

    /**
     * Delete landing page
     */
    public function delete(LandingPage $page): void
    {
        $page->delete();
    }
}
