<?php

namespace App\Repositories;

use App\Models\AffiliateEarning;
use Illuminate\Support\Str;

class AffiliateEarningRepository
{
    public function findByAffiliate(string $affiliateId)
    {
        return AffiliateEarning::query()
            ->where('affiliate_id', $affiliateId)
            ->latest()
            ->get();
    }

    public function create(array $data): AffiliateEarning
    {
        return AffiliateEarning::create(array_merge($data, [
            'id' => Str::uuid(),
        ]));
    }
}
