<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Package;
use App\Models\Voucher;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $users = User::all();
        $packages = Package::all();
        $vouchers = Voucher::all();

        foreach ($users as $user) {
            Transaction::factory()->count(3)->create([
                'user_id' => $user->id,
                'package_id' => $packages->random()->id,
                'voucher_id' => $vouchers->random()->id,
            ]);
        }
    }
}
