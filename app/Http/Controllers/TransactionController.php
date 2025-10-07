<?php

namespace App\Http\Controllers;

use App\Services\PembayaranServices;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    protected PembayaranServices $pembayaranServices;

    public function __construct(PembayaranServices $pembayaranServices)
    {
        $this->pembayaranServices = $pembayaranServices;
    }

    public function index(){
        return response()->json([
            'message' => 'Transaction retrieved successfully',
            'data' => $this->pembayaranServices->getAllTransactions()
        ], 200);
    }

    
}
