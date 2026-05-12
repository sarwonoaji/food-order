<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Product::create([
        'name' => 'Mie Pedas',
        'price' => 15000,
        'image' => 'mie.jpg',
        'description' => 'Mie pedas level 1-5'
    ]);

    Product::create([
        'name' => 'Es Teh',
        'price' => 5000,
        'image' => 'esteh.jpg',
        'description' => 'Minuman segar'
    ]);
}
}
