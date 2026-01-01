<?php

namespace Database\Seeders;

use App\Models\Voucher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        Voucher::create([
            'id' => Str::uuid(),
            'code' => 'DISKON50',
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'max_discount' => 50000,
            'voucher_type' => 'admin',
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
    }
}
