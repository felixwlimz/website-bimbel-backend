<?php

namespace App\Services;

use App\Repositories\WithdrawalRepository;
use Illuminate\Support\Facades\DB;

class WithdrawalServices
{
    public function __construct(
        protected WithdrawalRepository $withdrawalRepo
    ) {}

    public function getAll()
    {
        return $this->withdrawalRepo->findAll();
    }

    public function getById(string $id)
    {
        return $this->withdrawalRepo->findById($id);
    }

    public function getByAffiliate(string $affiliateId)
    {
        return $this->withdrawalRepo->findByAffiliate($affiliateId);
    }

    public function request(array $data)
    {
        return DB::transaction(fn () => $this->withdrawalRepo->create($data));
    }

    public function approve(string $withdrawalId, string $approvedBy)
    {
        return DB::transaction(function () use ($withdrawalId, $approvedBy) {
            $withdrawal = $this->withdrawalRepo->findById($withdrawalId);
            return $this->withdrawalRepo->updateStatus($withdrawal, 'completed', $approvedBy);
        });
    }

    public function reject(string $withdrawalId, string $approvedBy)
    {
        return DB::transaction(function () use ($withdrawalId, $approvedBy) {
            $withdrawal = $this->withdrawalRepo->findById($withdrawalId);
            return $this->withdrawalRepo->updateStatus($withdrawal, 'rejected', $approvedBy);
        });
    }
}
