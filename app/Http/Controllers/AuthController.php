<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function login(Request $request){
        return $this->authServices->login($request);
    }

    public function register(Request $request){
        return $this->authServices->register($request);
    }

    public function index()
    {
        $users = $this->authServices->getCurrentUser();
        return response()->json([
            'message' => 'User retrieved successfully',
            'code' => 200,
            'data' => $users
        ]);
    }

    public function getAllUsers(){
        return $this->authServices->getAllUsers();
    }

    public function update(Request $request)
    {
        $updated = $this->authServices->updateUser($request);

        return response()->json([
            'message' => 'User updated successfully',
            'code' => 200,
            'data' => $updated
        ]);
    }

}
