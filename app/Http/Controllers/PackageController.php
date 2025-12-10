<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PackageServices;

class PackageController extends Controller
{
    //

    protected PackageServices $packageServices;

    public function __construct(PackageServices $packageServices)
    {
        $this->packageServices = $packageServices;
    }

    public function index(){
        $packages = $this->packageServices->getAllPackages();
        return response()->json([
            'message' => 'Packages retrieved successfully',
            'data' => $packages
        ], 200);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:materi,soal,bundling',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'thumbnail' => 'required|url',
            'is_published' => 'sometimes|boolean',
        ]);
        $package = $this->packageServices->createPackage($validated);

        return response()->json([
            'message' => 'Package created successfully',
            'data' => $package
        ], 201);
    }

    public function show($id){
        $package = $this->packageServices->getPackageById($id);
        if (!$package) {
            return response()->json([
                'message' => 'Package not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Package retrieved successfully',
            'data' => $package
        ], 200);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:materi,soal,bundling',
            'description' => 'sometimes|string',
            'price' => 'sometimes|integer|min:0',
            'duration_minutes' => 'sometimes|integer|min:1',
            'thumbnail' => 'sometimes|url',
            'is_published' => 'sometimes|boolean',
        ]);
        $package = $this->packageServices->updatePackage($id, $validated);
        if (!$package) {
            return response()->json([
                'message' => 'Package not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Package updated successfully',
            'data' => $package
        ], 200);
    }

    public function destroy($id){
        $deleted = $this->packageServices->deletePackage($id);
        if (!$deleted) {
            return response()->json([
                'message' => 'Package not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Package deleted successfully'
        ], 200);
    }
}
