<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $fashion = Category::where('name', 'Fashion')->first();
        $makanan = Category::where('name', 'Makanan & Minuman')->first();
        
        $products = [
            [
                'name' => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone Samsung Galaxy A54 dengan layar Super AMOLED 6.4 inci, kamera 50MP, RAM 8GB, dan storage 128GB. Dilengkapi dengan baterai 5000mAh dan fast charging.',
                'price' => 4500000,
                'stock' => 25,
                'category_id' => $elektronik->id,
                'is_active' => 1,
                'image' => 'storage/products/hp.jpg',
                
            ],
            [
                'name' => 'Laptop ASUS VivoBook 14',
                'description' => 'Laptop ASUS VivoBook 14 dengan prosesor Intel Core i5, RAM 8GB DDR4, SSD 512GB, dan layar 14 inci Full HD. Perfect untuk produktivitas sehari-hari.',
                'price' => 7200000,
                'stock' => 15,
                'category_id' => $elektronik->id,
                'is_active' => 1,
                'image' => 'storage/products/laptop.jpg',
            ],
            [
                'name' => 'Kaos Polo Lacoste',
                'description' => 'Kaos polo premium dari Lacoste dengan bahan 100% cotton, desain klasik dan nyaman dipakai. Tersedia dalam berbagai warna dan ukuran.',
                'price' => 350000,
                'stock' => 50,
                'category_id' => $fashion->id,
                'is_active' => 1,
                'image' => 'storage/products/polo.jpg',
            ],
            [
                'name' => 'Jeans Levi\'s 501',
                'description' => 'Jeans original Levi\'s 501 dengan fit klasik dan bahan denim berkualitas tinggi. Tahan lama dan tidak mudah pudar warnanya.',
                'price' => 800000,
                'stock' => 30,
                'category_id' => $fashion->id,
                'is_active' => 1,
                'image' => 'storage/products/jeans.jpg',
            ]
        ];

        foreach ($products as $product) {
            Products::create($product);
        }
    }
}
