<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Pembeli
        User::updateOrCreate(
            ['email' => 'pembeli@gmail.com'],
            [
                'name' => 'Budi Pembeli',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
            ]
        );

        // 3. Pastikan ada Supplier sample jika belum ada
        $supplier = Supplier::first();
        if (!$supplier) {
            $supplier = Supplier::create([
                'supplier_name' => 'PT Sumber Makmur',
                'phone' => '081234567890',
                'email' => 'sumbermakmur@example.com',
            ]);
        }

        // 4. Pastikan ada beberapa Produk sample untuk diuji oleh pembeli
        if (Product::count() < 3) {
            Product::firstOrCreate(
                ['barcode_number' => 'PRD-001'],
                [
                    'product_name' => 'Kopi Arabika Premium 250g',
                    'buy_price' => 35000,
                    'sell_price' => 50000,
                    'supplier_id' => $supplier->id,
                ]
            );

            Product::firstOrCreate(
                ['barcode_number' => 'PRD-002'],
                [
                    'product_name' => 'Teh Hijau Organik 100g',
                    'buy_price' => 18000,
                    'sell_price' => 28000,
                    'supplier_id' => $supplier->id,
                ]
            );

            Product::firstOrCreate(
                ['barcode_number' => 'PRD-003'],
                [
                    'product_name' => 'Susu Almond 1 Liter',
                    'buy_price' => 25000,
                    'sell_price' => 38000,
                    'supplier_id' => $supplier->id,
                ]
            );
        }
    }
}
