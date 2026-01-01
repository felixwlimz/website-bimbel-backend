<?php

namespace App\Services;

use App\Repositories\VoucherRepository;

class VoucherServices
{
    public function __construct(
        protected VoucherRepository $voucherRepo
    ) {}

    public function validate(string $code)
    {
        return $this->voucherRepo->findByCode($code);
    }
}
