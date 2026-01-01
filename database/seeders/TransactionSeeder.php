<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        $package = Package::first();

        Transaction::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'invoice_number' => 'INV-' . time(),
            'original_amount' => $package->price,
            'discount_amount' => 0,
            'final_amount' => $package->price,
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
