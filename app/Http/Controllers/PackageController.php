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
}
