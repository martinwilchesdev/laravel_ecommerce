<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(10)->create();
        Product::create([
            'nombre' => 'Teclado Genius USB KB-100',
            'descripcion' => 'Para uso domestico y en oficina',
            'precio' => 100,
            'imagen' => 'https://electronicasannicolas.com.co/wp-content/uploads/2022/02/TECLADO-GENIUS-USB-KB-100-4554.png',
            'categoria_id' => 1
        ]);
    }
}
