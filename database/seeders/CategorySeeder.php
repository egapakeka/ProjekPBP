<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik'],
            ['name' => 'Fashion'],
            ['name' => 'Makanan & Minuman'],
            ['name' => 'Kesehatan & Kecantikan'],
            ['name' => 'Olahraga & Outdoor'],
            ['name' => 'Buku & Alat Tulis'],
            ['name' => 'Rumah & Taman'],
            ['name' => 'Otomotif']
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']]);
        }
    }
}
