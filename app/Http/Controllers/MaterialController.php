<?php

namespace App\Http\Controllers;

use App\Services\MateriServices;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct(
        protected MateriServices $materialService
    ) {}

    /**
     * ADMIN - get all materials
     */
    public function index()
    {
        return response()->json([
            'data' => $this->materialService->getAll()
        ]);
    }

    /**
     * USER/ADMIN - materials by package
     */
    public function byPackage(string $packageId)
    {
        return response()->json([
            'data' => $this->materialService->getByPackage($packageId)
        ]);
    }

    /**
     * ADMIN - create material
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|uuid|exists:packages,id',
            'title'      => 'required|string|max:255',
            'drive_link' => 'required|url',
            'preview'    => 'boolean',
            'order'      => 'nullable|integer',
        ]);

        return response()->json([
            'message' => 'Material berhasil ditambahkan',
            'data'    => $this->materialService->create($validated),
        ], 201);
    }

    /**
     * ADMIN - update material
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'      => 'sometimes|string|max:255',
            'drive_link' => 'sometimes|url',
            'preview'    => 'sometimes|boolean',
            'order'      => 'nullable|integer',
        ]);

        return response()->json([
            'message' => 'Material berhasil diperbarui',
            'data'    => $this->materialService->update($id, $validated),
        ]);
    }

    /**
     * ADMIN - delete material
     */
    public function destroy(string $id)
    {
        $this->materialService->delete($id);

        return response()->json([
            'message' => 'Material berhasil dihapus'
        ]);
    }
}
