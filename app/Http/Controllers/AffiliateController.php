<?php

namespace App\Http\Controllers;

use App\Services\AffiliateServices;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function __construct(
        protected AffiliateServices $affiliateService
    ) {}

    public function index()
    {
        return response()->json($this->affiliateService->getAll());
    }

    public function me(Request $request)
    {
        return response()->json(
            $this->affiliateService->getMyAffiliate($request->user()->id)
        );
    }

    public function apply(Request $request)
    {
        return response()->json(
            $this->affiliateService->apply(
                $request->user()->id,
                $request->only(['bank_name','account_number','account_name'])
            ),
            201
        );
    }

    public function approve(string $id)
    {
        return response()->json(
            $this->affiliateService->approve($id)
        );
    }
}
