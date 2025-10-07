<?php

namespace App\Repositories;

use App\Models\Material;

class MaterialRepository
{


    public function create($data)
    {
        return Material::create($data);
    }

    public function findAll(){
        return Material::with(['package'])->get();
    }
}
