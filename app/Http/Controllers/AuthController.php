<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServices $authService
    ) {}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $this->authService->register($validated);

        return response()->json([
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($validated);

        return response()->json([
            'message' => 'Login successful',
            'user'    => $result['user'],
            'token'   => $result['token'],
        ]);
    }

    public function me()
    {
        $user = $this->authService->getCurrentUser();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        return response()->json($user);
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
