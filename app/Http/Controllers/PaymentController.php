<?php
namespace App\Http\Controllers;

use App\Services\PaymentServices;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentServices $paymentService
    ) {}

    public function create(Request $request)
    {
        $validated = $request->validate([
            'package_id'   => 'required|uuid',
            'voucher_code' => 'nullable|string',
        ]);

        return response()->json(
            $this->paymentService->createPayment($validated),
            201
        );
    }
}
