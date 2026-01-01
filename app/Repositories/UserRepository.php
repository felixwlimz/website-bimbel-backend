<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * =================================
     * QUERY
     * =================================
     */

    /**
     * Ambil semua user (admin / super admin)
     * Anti N+1
     */
    public function findAll()
    {
        return User::query()
            ->with([
                'affiliate:id,user_id,code,status',
                'affiliate.withdrawals:id,affiliate_id,amount,status',
                'affiliate.earnings:id,affiliate_id,commission_amount,status',
            ])
            ->select([
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ])
            ->latest()
            ->get();
    }

    /**
     * Ambil user by ID
     */
    public function findById(string $id): User
    {
        return User::query()
            ->with([
                'affiliate:id,user_id,code,status',
                'affiliate.withdrawals:id,affiliate_id,amount,status',
                'affiliate.earnings:id,affiliate_id,commission_amount,status',
            ])
            ->select([
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ])
            ->findOrFail($id);
    }

    /**
     * Ambil user by email (auth / login)
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * =================================
     * MUTATION
     * =================================
     */

    /**
     * Create user (register / admin create)
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Update user by ID
     * (tidak bergantung auth())
     */
    public function update(string $id, array $data): User
    {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }

    /**
     * Delete user
     */
    public function delete(string $id): bool
    {
        return User::where('id', $id)->delete() > 0;
    }
}
