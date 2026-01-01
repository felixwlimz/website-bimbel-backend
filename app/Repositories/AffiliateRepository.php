<?php

namespace App\Repositories;

use App\Models\Affiliate;
use Illuminate\Support\Str;

class AffiliateRepository
{
    public function findAll()
    {
        return Affiliate::query()
            ->with([
                'user:id,name,email',
                'earnings:id,affiliate_id,commission_amount,status',
                'withdrawals:id,affiliate_id,amount,status',
            ])
            ->latest()
            ->get();
    }

    public function findByUserId(string $userId): ?Affiliate
    {
        return Affiliate::query()
            ->with(['earnings', 'withdrawals'])
            ->where('user_id', $userId)
            ->first();
    }

    public function findById(string $id): Affiliate
    {
        return Affiliate::query()
            ->with(['user', 'earnings', 'withdrawals'])
            ->findOrFail($id);
    }

    public function create(string $userId): Affiliate
    {
        return Affiliate::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'code' => strtoupper(Str::random(10)),
            'status' => 'pending',
        ]);
    }

    public function updateStatus(Affiliate $affiliate, string $status): Affiliate
    {
        $affiliate->update(['status' => $status]);
        return $affiliate->fresh();
    }
}
