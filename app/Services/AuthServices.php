<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthServices
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

      public function register(array $data): void
    {
        $data['password'] = Hash::make($data['password']);

        $this->userRepository->create($data);
    }

    
    public function login(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function updateCurrentUser(array $data)
    {
        return $this->userRepository->update( auth()->id(), $data);
    }

    /**
     * ============================
     * DELETE USER
     * ============================
     */
    public function deleteUser(string $id): void
    {
        $this->userRepository->delete($id);
    }
}
