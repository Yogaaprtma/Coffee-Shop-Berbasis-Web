<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PromoCode;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromoCode::updateOrCreate(
            ['code' => 'KOPIHEMAT'],
            [
                'description' => 'Diskon 10% minimal pembelian Rp 30.000',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'max_discount' => 20000,
                'min_purchase' => 30000,
                'usage_limit' => 100,
                'used_count' => 0,
                'valid_from' => now()->subDay(),
                'valid_until' => now()->addMonth(),
                'is_active' => true,
            ]
        );

        PromoCode::updateOrCreate(
            ['code' => 'COFFEEFIRST'],
            [
                'description' => 'Diskon flat Rp 15.000 minimal pembelian Rp 50.000',
                'discount_type' => 'fixed',
                'discount_value' => 15000,
                'max_discount' => null,
                'min_purchase' => 50000,
                'usage_limit' => 50,
                'used_count' => 0,
                'valid_from' => now()->subDay(),
                'valid_until' => now()->addMonth(),
                'is_active' => true,
            ]
        );
    }
}
