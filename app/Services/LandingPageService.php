<?php

namespace App\Services;

use App\Repositories\LandingPageRepository;
use Illuminate\Support\Facades\DB;

class LandingPageService
{
    public function __construct(
        protected LandingPageRepository $landingRepo
    ) {}

    public function getPublic()
    {
        return $this->landingRepo->getPublished();
    }

    public function getAll()
    {
        return $this->landingRepo->getAll();
    }

    public function getById(string $id)
    {
        return $this->landingRepo->findById($id);
    }

    public function create(array $data)
    {
        return DB::transaction(fn () => $this->landingRepo->create($data));
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $page = $this->landingRepo->findById($id);
            return $this->landingRepo->update($page, $data);
        });
    }

    public function publish(string $id)
    {
        return DB::transaction(function () use ($id) {
            $page = $this->landingRepo->findById($id);
            return $this->landingRepo->publish($page);
        });
    }

    public function unpublish(string $id)
    {
        return DB::transaction(function () use ($id) {
            $page = $this->landingRepo->findById($id);
            return $this->landingRepo->unpublish($page);
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $page = $this->landingRepo->findById($id);
            $this->landingRepo->delete($page);
        });
    }
}
