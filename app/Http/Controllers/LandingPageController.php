<?php

namespace App\Http\Controllers;

use App\Services\LandingPageService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function __construct(
        protected LandingPageService $landingService
    ) {}

    public function public()
    {
        return response()->json(
            $this->landingService->getPublic()
        );
    }

    public function index()
    {
        return response()->json(
            $this->landingService->getAll()
        );
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'slug',
            'description',
            'type',
            'order',
            'status',
        ]);
        
        // 📸 HANDLE IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store(
                'landing-pages',
                'public'
            );

            // SIMPAN STRING PATH
            $data['image_path'] = $path;
        }

        $landing = $this->landingService->create($data);

        return response()->json([
            'message' => 'Landing page created',
            'data' => $landing,
        ], 201);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'slug'        => 'sometimes|string|unique:landing_pages,slug,' . $id,
            'description' => 'nullable|string',
            'image_path'  => 'nullable|string',
            'type'        => 'sometimes|in:hero,section,banner,testimonial',
            'order'       => 'nullable|integer|min:0',
            'status'      => 'sometimes|in:draft,published',
        ]);

        return response()->json([
            'message' => 'Landing page berhasil diperbarui',
            'data' => $this->landingService->update($id, $validated),
        ]);
    }

    public function destroy(string $id)
    {
        $this->landingService->delete($id);

        return response()->json([
            'message' => 'Landing page berhasil dihapus',
        ]);
    }

    public function publish(string $id)
    {
        return response()->json(
            $this->landingService->publish($id)
        );
    }
}
