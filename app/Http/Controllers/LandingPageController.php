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
        return response()->json(
            $this->landingService->create($request->all(), $request->user()->id),
            201
        );
    }

    public function publish(string $id)
    {
        return response()->json(
            $this->landingService->publish($id)
        );
    }
}
