<?php 

namespace App\Repositories;

use App\Models\Package;

class PackageRepository{

    public function findAll(){
        return Package::all();
    }

    public function find($id){
        return Package::findOrFail($id);
    }

    public function create(array $data){
        return Package::create($data);
    }

    public function update($id, $data){
        $package = Package::findOrFail($id);
        $package->update($data);
        return $package;
    }

    public function delete($id){
        $package = Package::findOrFail($id);
        $package->delete();
        return $package;
    }
}
