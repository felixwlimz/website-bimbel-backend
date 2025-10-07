<?php 

namespace App\Repositories;

use App\Models\Withdrawal;

class WithdrawalRepository{

    public function findAll(){
      return Withdrawal::with(['user', 'affiliate.user'])->get();
    }

    public function find($id){
        return Withdrawal::findOrFail($id);
    }

    public function create($data){
        return Withdrawal::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'withdrawal_date' => $data['withdrawal_date'],
        ]);
    }

    public function update($id, $data){
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->update($data);
        return $withdrawal;
    }
}