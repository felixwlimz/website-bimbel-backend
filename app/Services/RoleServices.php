<?php

use App\Models\User;
use App\Models\Roles;

class RoleServices
{

    protected UserRepository $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function assignRole(User $user, $roleName)
    {
        $role = $this->userRepository->getRole($user, $roleName);
        if (!$role) {
            return false;
        }

        $this->userRepository->assignRole($user, $role);
        return true;
    }

    public function removeRole(User $user, $roleName)
    {
        $role = $this->userRepository->getRole($user, $roleName);
        if (!$role) {
            return false;
        }

        $this->userRepository->removeRole($user, $role);
        return true;
    }
}
