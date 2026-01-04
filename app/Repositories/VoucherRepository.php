<?php

namespace App\Repositories;

use App\Models\Voucher;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

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
        return Voucher::create([
            'id' => Str::uuid(),        // ⬅️ penting (karena UUID)
            'code' => $data['code'],
            'discount_value' => $data['discount_value'],
            'discount_type' => $data['discount_type'],
            'max_usage' => $data['max_usage'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'created_by' => auth()->id()
        ]);
    }

    public function update(string $id, array $data): Voucher
    {
        $voucher = $this->findById($id);
        $voucher->update($data);

        return $voucher;
    }

    public function delete(string $id): void
    {
        $voucher = $this->findById($id);
        $voucher->delete();
    }


    public function incrementUsage(Voucher $voucher): void
    {
        $voucher->increment('used_count');
    }
}
