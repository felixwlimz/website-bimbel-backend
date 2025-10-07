<?php

namespace App\Repositories;

use App\Models\Affiliate;
use App\Models\Withdrawal;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Str;

class AffiliateRepository
{

    public function findAll()
    {
        return Affiliate::with(['user', 'affiliateEarnings'])->get();
    }


    public function create($userId, array $data)
    {
        $affiliate = Affiliate::create([
            'code' => Str::upper(Str::random(10)),
            'user_id' => $userId,
            'commission_rate' => 0,
            'is_approved' => false,
        ]);

        Withdrawal::create([
            'id' => Str::uuid(),
            'affiliate_id' => $affiliate->id, 
            'amount' => 0,
            'status' => 'pending',
            'approved_by' => $userId,
            'account_name' => $data['namaPemilikRekening'],
            'bank_name' => $data['namaBank'],
            'account_number' => $data['noRekening'],
        ]);

        return $affiliate;
    }
}
