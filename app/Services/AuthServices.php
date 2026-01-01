<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthServices
{
    public function __construct(
        protected UserRepository $userRepo
    ) {}

    /**
     * ============================
     * REGISTER
     * ============================
     */
    public function register(array $data)
    {
        // validasi biasanya di FormRequest
        $user = $this->userRepo->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => 'user',
        ]);

        // kirim email verifikasi (optional)
        // event(new Registered($user));

        return $user;
    }

    /**
     * ============================
     * LOGIN
     * ============================
     */
    public function login(array $credentials, bool $remember = false)
    {
        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        return Auth::user();
    }

    /**
     * ============================
     * LOGOUT
     * ============================
     */
    public function logout()
    {
        Auth::logout();
    }
}
