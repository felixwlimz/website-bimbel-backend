<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserServices $userService
    ) {}

    public function index()
    {
        return response()->json($this->userService->getAll());
    }

    public function show(string $id)
    {
        return response()->json($this->userService->getById($id));
    }

    public function update(Request $request, string $id)
    {
        return response()->json(
            $this->userService->update($id, $request->only(['name','email','password']))
        );
    }

    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return response()->noContent();
    }
}
