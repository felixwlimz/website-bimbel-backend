<?php 

namespace App\Repositories;

use App\Models\LandingPage;


class LandingPageRepository {


    public function find(){
        return LandingPage::first();
    }

    public function create($userId, array $data){
        return LandingPage::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'file_path' => $data['file_path'],
            'slug' => $data['slug'],
        ]);
    }
    

}