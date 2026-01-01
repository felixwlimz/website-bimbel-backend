<?php

namespace App\Services;

use App\Repositories\AffiliateRepository;
use App\Repositories\WithdrawalRepository;
use Illuminate\Support\Facades\DB;

class AffiliateServices
{
    public function __construct(
        protected AffiliateRepository $affiliateRepo,
        protected WithdrawalRepository $withdrawalRepo
    ) {}

    public function getAll()
    {
        return $this->affiliateRepo->findAll();
    }

    public function getById(string $id)
    {
        return $this->affiliateRepo->findById($id);
    }

    public function getMyAffiliate(string $userId)
    {
        return $this->affiliateRepo->findByUserId($userId);
    }

    /**
     * User apply affiliate + simpan data bank (withdrawal record initial)
     */
    public function apply(string $userId, array $bankData)
    {
        return DB::transaction(function () use ($userId, $bankData) {
            $affiliate = $this->affiliateRepo->create($userId);

            $this->withdrawalRepo->create([
                'affiliate_id'   => $affiliate->id,
                'amount'         => 0,
                'status'         => 'pending',
                'bank_name'      => $bankData['bank_name'],
                'account_number' => $bankData['account_number'],
                'account_name'   => $bankData['account_name'],
            ]);

            return $affiliate->load('withdrawals');
        });
    }

    public function approve(string $affiliateId)
    {
        return DB::transaction(function () use ($affiliateId) {
            $affiliate = $this->affiliateRepo->findById($affiliateId);
            return $this->affiliateRepo->updateStatus($affiliate, 'approved');
        });
    }

    public function suspend(string $affiliateId)
    {
        return DB::transaction(function () use ($affiliateId) {
            $affiliate = $this->affiliateRepo->findById($affiliateId);
            return $this->affiliateRepo->updateStatus($affiliate, 'suspended');
        });
    }
}
