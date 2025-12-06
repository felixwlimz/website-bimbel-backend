<?php

namespace App\Services;

use App\Repositories\VoucherRepository;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VoucherServices
{
    protected $repo;

    public function __construct(VoucherRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Ambil semua voucher
     */
    public function getAll()
    {
        return $this->repo->findAll();
    }

    /**
     * Membuat voucher baru
     */
    public function create($request)
    {
        $validated = $request->validate([
            'code'         => 'required|string|unique:vouchers,code',
            'discount_rp'  => 'required|integer|min:1',
            'type'         => 'required|in:fixed,percentage',
            'active'       => 'required|boolean',
        ]);

        $validated['id'] = Str::uuid();
        $validated['code'] = strtoupper($validated['code']);
        $validated['created_by'] = auth()->id();

        return $this->repo->create($validated);
    }

    /**
     * Update voucher
     */
    public function update($id, $request)
    {
        $validated = $request->validate([
            'discount_rp' => 'integer|min:1',
            'type'        => 'in:fixed,percentage',
            'active'      => 'boolean',
        ]);

        return $this->repo->update($id, $validated);
    }

    /**
     * Hapus voucher
     */
    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    /**
     * Validasi voucher dari user (frontend apply voucher)
     */
    public function validateVoucher($request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = $this->repo->findAll()
            ->where('code', strtoupper($request->code))
            ->where('active', true)
            ->first();

        if (!$voucher) {
            throw ValidationException::withMessages([
                'code' => ['Voucher tidak valid atau tidak aktif.']
            ]);
        }

        return [
            'valid'       => true,
            'voucher_id'  => $voucher->id,
            'type'        => $voucher->type,
            'discount'    => $voucher->discount_rp
        ];
    }
}
