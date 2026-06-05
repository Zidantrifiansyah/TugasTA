<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CupangProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cupang_products')->insert([
            [
                'nama' => 'Cupang Red Dragon',
                'varian' => 'Merah Cerah',
                'deskripsi' => 'Ikan cupang merah dengan corak dragon yang indah',
                'harga' => 75000,
                'stok' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cupang Blue Marble',
                'varian' => 'Biru Marmer',
                'deskripsi' => 'Ikan cupang biru dengan pola marmer yang unik',
                'harga' => 85000,
                'stok' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cupang Black Lace',
                'varian' => 'Hitam',
                'deskripsi' => 'Ikan cupang hitam dengan sirip transparan',
                'harga' => 65000,
                'stok' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cupang White Platinum',
                'varian' => 'Putih Metalik',
                'deskripsi' => 'Ikan cupang putih dengan kilau metalik yang memukau',
                'harga' => 95000,
                'stok' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cupang Orange Gold',
                'varian' => 'Orange Keemasan',
                'deskripsi' => 'Ikan cupang orange dengan warna keemasan yang elegan',
                'harga' => 80000,
                'stok' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cupang Green Turquoise',
                'varian' => 'Hijau Turquoise',
                'deskripsi' => 'Ikan cupang hijau dengan nuansa turquoise yang segar',
                'harga' => 70000,
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
