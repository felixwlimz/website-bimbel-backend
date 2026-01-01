<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Support\Str;

class AffiliateSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();

        Affiliate::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'code' => strtoupper(Str::random(8)),
            'status' => 'approved',
        ]);
    }
}

