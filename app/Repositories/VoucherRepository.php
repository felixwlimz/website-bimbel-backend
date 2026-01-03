<?php

namespace App\Repositories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;

class VoucherRepository
{

    public function findAll(): Collection
    {
        return Voucher::latest()->get();
    }


    public function findById(string $id): Voucher
    {
        return Voucher::findOrFail($id);
    }


    public function findValidByCode(string $code): ?Voucher
    {
        return Voucher::query()
            ->where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('max_usage')
                    ->orWhereColumn('used_count', '<', 'max_usage');
            })
            ->first();
    }

    public function create(array $data): Voucher
    {
        return Voucher::create($data);
    }

    public function update(string $id, array $data): Voucher
    {
        $voucher = $this->findById($id);
        $voucher->update($data);

        return $voucher;
    }

    /**
     * ============================
     * DELETE
     * ============================
     */
    public function delete(string $id): void
    {
        $voucher = $this->findById($id);
        $voucher->delete();
    }

    /**
     * ============================
     * INCREMENT USAGE
     * ============================
     */
    public function incrementUsage(Voucher $voucher): void
    {
        $voucher->increment('used_count');
    }
}
