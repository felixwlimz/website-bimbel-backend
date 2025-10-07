<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use RoleServices;

class UserController extends Controller
{

    protected RoleServices $roleServices;

    public function __construct(RoleServices $roleServices)
    {
        $this->roleServices = $roleServices;
    }

    public function assignRole(Request $request, User $user ){
        $role = $request->input('role');

        $isSuccess = $this->roleServices->assignRole($user, $role);
        if ($isSuccess) { 
            return redirect()->back()->with('success', 'Role assigned successfully.');
        } 
        return redirect()->back()->with('error', 'Failed to assign role.');
    }

    public function removeRole(Request $request, User $user){
        $role = $request->input('role');

        $isSuccess = $this->roleServices->removeRole($user, $role);
        if ($isSuccess) {
            return redirect()->back()->with('success', 'Role removed successfully.');
        }
        return redirect()->back()->with('error', 'Failed to remove role.');
    }
}
