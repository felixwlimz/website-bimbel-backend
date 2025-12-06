<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Illuminate\Http\Request;
use App\Services\VoucherServices;

class VoucherController extends Controller
{
    protected $service;

    public function __construct(VoucherServices $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json([
            'data' => $this->service->getAll()
        ]);
    }

    public function store(Request $request)
    {
        $voucher = $this->service->create($request);

        return response()->json([
            'message' => "Voucher berhasil dibuat",
            'data' => $voucher
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $voucher = $this->service->update($id, $request);

        return response()->json([
            'message' => 'Voucher berhasil diperbarui',
            'data' => $voucher
        ]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'message' => 'Voucher berhasil dihapus'
        ]);
    }

    public function check(Request $request)
    {
        $result = $this->service->validateVoucher($request);

        return response()->json($result);
    }
}
