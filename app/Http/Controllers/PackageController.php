<?php

namespace App\Http\Controllers;

use App\Services\PackageServices;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(
        protected PackageServices $packageService
    ) {}

    /**
     * =========================
     * PUBLIC
     * =========================
     */
    public function index()
    {
        return response()->json(
            $this->packageService->getPublished()
        );
    }

    public function show(string $id)
    {
        return response()->json(
            $this->packageService->show($id)
        );
    }

    /**
     * =========================
     * ADMIN
     * =========================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'type'             => 'required|in:material,tryout,bundle',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'passing_grade'    => 'nullable|integer|min:0|max:100',
            'thumbnail'        => 'nullable|string',
            'status'           => 'nullable|in:draft,published',
        ]);

        return response()->json(
            $this->packageService->create($validated),
            201
        );
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'            => 'sometimes|string|max:255',
            'description'      => 'nullable|string',
            'type'             => 'sometimes|in:materi,soal,bundling',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'passing_grade'    => 'nullable|integer|min:0|max:100',
            'thumbnail'        => 'nullable|string',
            'status'           => 'nullable|in:draft,published',
        ]);

        return response()->json(
            $this->packageService->update($id, $validated)
        );
    }

    public function destroy(string $id)
    {
        $this->packageService->delete($id);
        return response()->noContent();
    }

    public function publish(string $id)
    {
        return response()->json(
            $this->packageService->publish($id)
        );
    }

    public function unpublish(string $id)
    {
        return response()->json(
            $this->packageService->unpublish($id)
        );
    }
}
