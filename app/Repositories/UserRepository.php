<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


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

    public function delete(string $id): bool
    {
        return User::where('id', $id)->delete() > 0;
    }

    public function createPasswordResetToken(string $email)
    {
        $token = Str::random(64);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $email],
                [
                    'token'      => Hash::make($token),
                    'created_at' => now(),
                ]
            );

        return $token;
    }

    public function resetPassword(string $email, string $newPassword): void
    {
        $user = $this->findByEmail($email);

        if (! $user) {
            throw new \Exception('User tidak ditemukan');
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }

    public function validatePasswordResetToken(string $email, string $token): bool
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record) {
            return false;
        }

        // token mismatch
        if (! Hash::check($token, $record->token)) {
            return false;
        }

        // expired (60 menit)
        return Carbon::parse($record->created_at)->addMinutes(60)->isFuture();
    }

}
