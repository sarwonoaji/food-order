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
    $products = [
        ['name' => 'Mie Pedas', 'price' => 15000, 'image' => 'mie_pedas.jpg', 'description' => 'Mie pedas level 1-5'],
        ['name' => 'Es Teh', 'price' => 5000, 'image' => 'es_teh.jpg', 'description' => 'Minuman segar'],
        ['name' => 'Nasi Goreng Spesial', 'price' => 20000, 'image' => 'nasi_goreng.jpg', 'description' => 'Nasi goreng dengan ayam dan telur'],
        ['name' => 'Mie Goreng', 'price' => 18000, 'image' => 'mie_goreng.jpg', 'description' => 'Mie goreng ala rumahan'],
        ['name' => 'Ayam Goreng', 'price' => 25000, 'image' => 'ayam_goreng.jpg', 'description' => 'Ayam goreng renyah'],
        ['name' => 'Ayam Bakar', 'price' => 26000, 'image' => 'ayam_bakar.jpg', 'description' => 'Ayam bakar bumbu kecap'],
        ['name' => 'Sate Ayam', 'price' => 22000, 'image' => 'sate_ayam.jpg', 'description' => 'Sate ayam dengan saus kacang'],
        ['name' => 'Sate Kambing', 'price' => 30000, 'image' => 'sate_kambing.jpg', 'description' => 'Sate kambing empuk'],
        ['name' => 'Sop Buntut', 'price' => 40000, 'image' => 'sop_buntut.jpg', 'description' => 'Sop buntut hangat dan sedap'],
        ['name' => 'Rawon', 'price' => 22000, 'image' => 'rawon.jpg', 'description' => 'Rawon daging dengan kuah khas'],
        ['name' => 'Gado-Gado', 'price' => 18000, 'image' => 'gado_gado.jpg', 'description' => 'Sayur dan bumbu kacang segar'],
        ['name' => 'Es Jeruk', 'price' => 6000, 'image' => 'es_jeruk.jpg', 'description' => 'Es jeruk segar'],
        ['name' => 'Jus Alpukat', 'price' => 12000, 'image' => 'jus_alpukat.jpg', 'description' => 'Jus alpukat krim'],
        ['name' => 'Kopi Susu', 'price' => 10000, 'image' => 'kopi_susu.jpg', 'description' => 'Kopi susu hangat'],
        ['name' => 'Roti Bakar', 'price' => 12000, 'image' => 'roti_bakar.jpg', 'description' => 'Roti bakar dengan selai pilihan'],
        ['name' => 'Martabak Manis', 'price' => 25000, 'image' => 'martabak_manis.jpg', 'description' => 'Martabak manis isi kacang dan coklat'],
        ['name' => 'Pancake', 'price' => 20000, 'image' => 'pancake.jpg', 'description' => 'Pancake dengan sirup maple'],
        ['name' => 'Soto Ayam', 'price' => 20000, 'image' => 'soto_ayam.jpg', 'description' => 'Soto ayam kuah bening'],
        ['name' => 'Bakso Spesial', 'price' => 22000, 'image' => 'bakso_spesial.jpg', 'description' => 'Bakso dengan isi telur dan pangsit'],
        ['name' => 'Es Campur', 'price' => 15000, 'image' => 'es_campur.jpg', 'description' => 'Es campur buah dan jelly'],
    ];

    foreach ($products as $p) {
        Product::create($p);
    }
}
}
