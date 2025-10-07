<?php

namespace App\Services;

use App\Repositories\WithdrawalRepository;


class WithdrawalServices
{

    protected WithdrawalRepository $withdrawalRepository;

    public function __construct(WithdrawalRepository $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }


    public function getAllWithdrawals()
    {
        return $this->withdrawalRepository->findAll();
    }

    public function getWithdrawalById($id)
    {
        return $this->withdrawalRepository->find($id);
    }

    public function createWithdrawal($data)
    {
        return $this->withdrawalRepository->create($data);
    }

    public function updateWithdrawal($id, $data)
    {
        return $this->withdrawalRepository->update($id, $data);
    }

}
