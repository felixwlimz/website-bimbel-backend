<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WithdrawalServices;

class WithdrawalController extends Controller
{
    protected WithdrawalServices $withdrawalServices;

    public function __construct(WithdrawalServices $withdrawalServices)
    {
        $this->withdrawalServices = $withdrawalServices;
    }


    public function index(){
        $withdrawals = $this->withdrawalServices->getAllWithdrawals();
        return response()->json([
            'message' => 'Withdrawals retrieved successfully',
            'data' => $withdrawals
        ], 200);
    }

    public function store(Request $request){
        $withdrawal = $this->withdrawalServices->createWithdrawal($request);
        return response()->json([
            'message' => 'Withdrawal created successfully',
            'data' => $withdrawal
        ], 201);
    }
}
