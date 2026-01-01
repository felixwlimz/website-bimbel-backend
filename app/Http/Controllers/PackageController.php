<?php

namespace App\Http\Controllers;

use App\Services\PackageServices;

class PackageController extends Controller
{
    public function __construct(
        protected PackageServices $packageService
    ) {}

    public function index()
    {
        return response()->json($this->packageService->getPublished());
    }

    public function show(string $id)
    {
        return response()->json($this->packageService->getById($id));
    }
}
