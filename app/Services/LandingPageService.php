<?php

namespace App\Services;

use App\Models\LandingPage;
use App\Repositories\LandingPageRepository;
use Illuminate\Support\Facades\Auth;


class LandingPageService
{
    protected LandingPageRepository $landingPageRepository;

    public function __construct(LandingPageRepository $landingPageRepository)
    {
        $this->landingPageRepository = $landingPageRepository;
    }


    public function getLandingPage()
    {
        return $this->landingPageRepository->find();
    }


    public function addLandingPage(array $data)
    {
        $userId = Auth::id();
        return $this->landingPageRepository->create($userId, $data);
    }
}
