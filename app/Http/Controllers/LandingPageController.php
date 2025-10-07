<?php

namespace App\Http\Controllers;

use App\Services\LandingPageService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    //
    protected LandingPageService $landingPageService;

    public function __construct(LandingPageService $landingPageService)
    {
        $this->landingPageService = $landingPageService;
    }

    public function index()
    {
        $landingPage = $this->landingPageService->getLandingPage();
        if (!$landingPage) {
            return response()->json(['message' => 'Landing page not found'], 404);
        }
        return response()->json($landingPage);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'slug' => 'required|string|unique:landing_page,slug',
        ]);

        $landingPage = $this->landingPageService->addLandingPage($data);
        return response()->json($landingPage, 201);
    }
}
