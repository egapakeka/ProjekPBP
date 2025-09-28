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
                'price' => 4500000,
                'stock' => 25,
                'category_id' => $elektronik->id,
                'is_active' => 1
            ],
            [
                'name' => 'Laptop ASUS VivoBook 14',
                'price' => 7200000,
                'stock' => 15,
                'category_id' => $elektronik->id,
                'is_active' => 1
            ],
            [
                'name' => 'Kaos Polo Lacoste',
                'price' => 350000,
                'stock' => 50,
                'category_id' => $fashion->id,
                'is_active' => 1
            ],
            [
                'name' => 'Jeans Levi\'s 501',
                'price' => 800000,
                'stock' => 30,
                'category_id' => $fashion->id,
                'is_active' => 1
            ],
            [
                'name' => 'Kopi Arabica Premium 1kg',
                'price' => 150000,
                'stock' => 100,
                'category_id' => $makanan->id,
                'is_active' => 1
            ],
            [
                'name' => 'Teh Earl Grey 100g',
                'price' => 75000,
                'stock' => 80,
                'category_id' => $makanan->id,
                'is_active' => 0
            ]
        ];

        foreach ($products as $product) {
            Products::create($product);
        }
    }
}
