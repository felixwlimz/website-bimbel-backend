<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findAll()
    {
        return User::with(['affiliate', 'withdrawals', 'vouchers'])->get();
    }

    public function findById($id)
    {
        return User::with(['affiliate', 'withdrawals', 'vouchers'])->findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }


    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }


   public function update(array $data){
        $user = auth()->user();
        $user->update($data);
        return $user;
   }
}
