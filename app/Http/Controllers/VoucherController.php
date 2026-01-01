<?php

namespace App\Http\Controllers;

use App\Services\VoucherServices;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherServices $voucherService
    ) {}

    public function validate(Request $request)
    {
        return response()->json(
            $this->voucherService->validate($request->code)
        );
    }
}
