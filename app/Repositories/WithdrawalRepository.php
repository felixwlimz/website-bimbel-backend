<?php

namespace App\Repositories;

use App\Models\Withdrawal;
use Illuminate\Support\Str;

class WithdrawalRepository
{

    public function findById(string $id): Withdrawal
    {
        return Withdrawal::query()
            ->with([
                'affiliate.user:id,name,email',
                'approvedBy:id,name,email',
            ])
            ->findOrFail($id);
    }

    /**
     * Ambil semua withdrawal milik affiliate
     */
    public function findByAffiliate(string $affiliateId)
    {
        return Withdrawal::query()
            ->with([
                'affiliate.user:id,name,email',
            ])
            ->where('affiliate_id', $affiliateId)
            ->latest()
            ->get();
    }

    /**
     * Ambil semua withdrawal (admin / super admin)
     */
    public function findAll()
    {
        return Withdrawal::query()
            ->with([
                'affiliate.user:id,name,email',
                'approvedBy:id,name,email',
            ])
            ->latest()
            ->get();
    }

    public function create(array $data): Withdrawal
    {
        return Withdrawal::create(array_merge($data, [
            'id' => Str::uuid(),
            'status' => $data['status'] ?? 'pending',
        ]));
    }

    /**
     * Update status withdrawal
     */
    public function updateStatus(
        Withdrawal $withdrawal,
        string $status,
        ?string $approvedBy = null
    ): Withdrawal {
        $withdrawal->update([
            'status'      => $status,
            'approved_by' => $approvedBy,
        ]);

        return $withdrawal->fresh();
    }
}
