<?php 

namespace App\Repositories;
use App\Models\Voucher;


class VoucherRepository{

    public function findAll(){
        return Voucher::all();
    }

    public function findById($id){
        return Voucher::findOrFail($id);
    }

    public function create(array $data): Voucher
    {
        return Voucher::create($data);
    }

    public function update($id, array $data): Voucher
    {
        $voucher = $this->findById($id);
        $voucher->update($data);
        return $voucher;
    }

    public function delete($id): void
    {
        $voucher = $this->findById($id);
        $voucher->delete();
    }

    

}