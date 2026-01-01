<?php

namespace App\Http\Controllers;

use App\Services\MateriServices;

class MaterialController extends Controller
{
    public function __construct(
        protected MateriServices $materialService
    ) {}

    public function byPackage(string $packageId)
    {
        return response()->json(
            $this->materialService->getByPackage($packageId)
        );
    }
}
