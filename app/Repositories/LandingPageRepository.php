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

    /**
     * Ambil satu section landing page by slug (public)
     */
    public function findPublishedBySlug(string $slug): ?LandingPage
    {
        return LandingPage::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
    }

    /**
     * ============================
     * ADMIN / SUPER ADMIN
     * ============================
     */

    /**
     * Ambil semua landing page (draft + published)
     * Untuk dashboard admin
     */
    public function getAll()
    {
        return LandingPage::query()
            ->with([
                'creator:id,name,email',
            ])
            ->orderBy('order')
            ->get();
    }

    /**
     * Ambil detail landing page (admin)
     */
    public function findById(string $id): LandingPage
    {
        return LandingPage::query()
            ->with('creator:id,name,email')
            ->findOrFail($id);
    }

    /**
     * ============================
     * MUTATION
     * ============================
     */

    /**
     * Create landing page (default: draft)
     */
    public function create(array $data, string $userId): LandingPage
    {
        return LandingPage::create([
            'id'          => Str::uuid(),
            'title'       => $data['title'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
            'image_path'  => $data['image_path'] ?? null,
            'type'        => $data['type'], // hero | section | banner | testimonial
            'order'       => $data['order'] ?? 0,
            'status'      => 'draft',
            'created_by'  => $userId,
        ]);
    }

    /**
     * Update landing page content
     */
    public function update(LandingPage $page, array $data): LandingPage
    {
        $page->update([
            'title'       => $data['title'] ?? $page->title,
            'slug'        => $data['slug'] ?? $page->slug,
            'description' => $data['description'] ?? $page->description,
            'image_path'  => $data['image_path'] ?? $page->image_path,
            'type'        => $data['type'] ?? $page->type,
            'order'       => $data['order'] ?? $page->order,
        ]);

        return $page->fresh();
    }

    /**
     * Publish landing page
     * (dipanggil dari Service / Super Admin)
     */
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
