<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserServices
{
    public function __construct(
        protected UserRepository $userRepo
    ) {}

    public function getAll()
    {
        return $this->userRepo->findAll();
    }

    public function getById(string $id)
    {
        return $this->userRepo->findById($id);
    }

    public function getByEmail(string $email)
    {
        return $this->userRepo->findByEmail($email);
    }

    public function create(array $data)
    {
        return DB::transaction(fn () => $this->userRepo->create($data));
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(fn () => $this->userRepo->update($id, $data));
    }

    public function delete(string $id): bool
    {
        return DB::transaction(fn () => $this->userRepo->delete($id));
    }
}
