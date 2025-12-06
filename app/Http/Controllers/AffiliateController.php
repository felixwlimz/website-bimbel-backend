<?php

namespace App\Http\Controllers;

use App\Services\AffiliateServices;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{

    protected AffiliateServices $affiliateServices;
    //
    public function __construct(AffiliateServices $affiliateServices)
    {
        $this->affiliateServices = $affiliateServices;
        
    }

    public function index(){
        $affiliates = $this->affiliateServices->getAffiliateOrders();
        return response()->json([
            'message' => 'Affiliates retrieved successfully',
            'data' => $affiliates
        ], 200);
    }

    public function store(Request $request){

        $affiliate = $this->affiliateServices->createAffiliate($request);

        return response()->json([
            'message' => 'Affiliate created successfully',
            'data' => $affiliate
        ], 201);

    }

    public function withdraw(Request $request){
        $withdraw = $this->affiliateServices->withdraw($request);

        return response()->json([
            'message' => 'Withdrawal created successfully',
            'data' => $withdraw
        ]);
    }
}
