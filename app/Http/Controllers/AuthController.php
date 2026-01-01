<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServices $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        return response()->json(
            $this->authService->register($request->validated()),
            201
        );
    }

    public function login(LoginRequest $request)
    {
        return response()->json(
            $this->authService->login(
                $request->validated(),
                $request->boolean('remember')
            )
        );
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->noContent();
    }
}
