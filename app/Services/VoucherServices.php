<?php

namespace App\Services;

use App\Repositories\VoucherRepository;
use Illuminate\Validation\ValidationException;

class VoucherServices
{
    public function __construct(
        protected VoucherRepository $voucherRepo
    ) {}

    /**
     * ============================
     * ADMIN
     * ============================
     */

    public function getAll()
    {
        return $this->voucherRepo->findAll();
    }

    public function getById(string $id)
    {
        return $this->voucherRepo->findById($id);
    }

    public function create(array $data)
    {
        return $this->voucherRepo->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->voucherRepo->update($id, $data);
    }

    public function delete(string $id): void
    {
        $this->voucherRepo->delete($id);
    }

    /**
     * ============================
     * USER
     * ============================
     * Validate voucher before checkout
     */
    public function validateVoucher(string $code)
    {
        $voucher = $this->voucherRepo->findValidByCode($code);

        if (! $voucher) {
            throw ValidationException::withMessages([
                'code' => 'Voucher tidak valid, sudah kadaluarsa, atau sudah habis.',
            ]);
        }

        return $voucher;
    }

    /**
     * ============================
     * AFTER TRANSACTION SUCCESS
     * ============================
     */
    public function useVoucher(string $code): void
    {
        $voucher = $this->voucherRepo->findValidByCode($code);

        if (! $voucher) {
            return;
        }

        $this->voucherRepo->incrementUsage($voucher);
    }
}
