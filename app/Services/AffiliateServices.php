<?php

namespace App\Services;
use App\Repositories\AffiliateRepository;
use Illuminate\Http\Request;

class AffiliateServices {


    protected AffiliateRepository $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
    }

    public function getAffiliateOrders()
    {
        return $this->affiliateRepository->findAll();
    }



    public function createAffiliate(Request $request)
    {
        $validated = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'noRekening' => 'required|string|max:20',
            'namaBank' => 'required|string|max:100',
            'namaPemilikRekening' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        return $this->affiliateRepository->create($user->id, $validated);
    }

}