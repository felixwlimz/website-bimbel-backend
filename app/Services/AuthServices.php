<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthServices
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = $this->userRepository->findByEmail($validated['email']);

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'The credentials are incorrect',
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login Successful',
            'status' => 200,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $this->userRepository->create($validated);

        return response()->json([
            'message' => 'User registered successfully',
            'code' => 201
        ], 201);
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }

    public function getCurrentUser()
    {
        $auth = auth()->user();
        return response()->json([
            'message' => 'User retrieved successfully',
            'code' => 200,
            'data' => $auth
        ]);
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);
        return $this->userRepository->update($validated);
    }
}
