<?php

namespace App\Http\Controllers;

use App\Services\VoucherServices;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherServices $voucherService
    ) {}

    /**
     * ============================
     * ADMIN ROUTES
     * ============================
     */

    public function index()
    {
        return response()->json([
            'message' => 'Voucher list retrieved successfully',
            'data' => $this->voucherService->getAll(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|unique:vouchers,code',
            'discount'    => 'required|numeric|min:1',
            'max_usage'   => 'nullable|integer|min:1',
            'expired_at'  => 'nullable|date',
            'is_active'   => 'boolean',
        ]);

        $voucher = $this->voucherService->create($validated);

        return response()->json([
            'message' => 'Voucher berhasil dibuat',
            'data' => $voucher,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'discount'    => 'sometimes|numeric|min:1',
            'max_usage'   => 'nullable|integer|min:1',
            'expired_at'  => 'nullable|date',
            'is_active'   => 'boolean',
        ]);

        $voucher = $this->voucherService->update($id, $validated);

        return response()->json([
            'message' => 'Voucher berhasil diperbarui',
            'data' => $voucher,
        ]);
    }

    public function destroy(string $id)
    {
        $this->voucherService->delete($id);

        return response()->json([
            'message' => 'Voucher berhasil dihapus',
        ]);
    }

    /**
     * ============================
     * USER ROUTE
     * ============================
     * Validate voucher code
     */
    public function validate(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $voucher = $this->voucherService->validateVoucher($validated['code']);

        return response()->json([
            'message' => 'Voucher valid',
            'data' => $voucher,
        ]);
    }
}
