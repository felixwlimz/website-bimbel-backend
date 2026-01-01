<?php

namespace App\Services;

use App\Repositories\AffiliateEarningRepository;
use Illuminate\Support\Facades\DB;

class AffiliateEarningServices
{
    public function __construct(
        protected AffiliateEarningRepository $earningRepo
    ) {}

    public function getByAffiliate(string $affiliateId)
    {
        return $this->earningRepo->findByAffiliate($affiliateId);
    }

    /**
     * Buat earning dari transaksi (dipanggil setelah payment PAID)
     */
    public function createFromTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // data minimal:
            // affiliate_id, transaction_id, commission_rate, commission_amount
            return $this->earningRepo->create([
                'affiliate_id'      => $data['affiliate_id'],
                'transaction_id'    => $data['transaction_id'],
                'commission_rate'   => $data['commission_rate'],
                'commission_amount' => $data['commission_amount'],
                'locked_until'      => now()->addMonth(),
                'status'            => 'locked',
            ]);
        });
    }
}
