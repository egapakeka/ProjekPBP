<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Mengambil kategori beserta produk aktifnya
            $categoriesWithProducts = Category::with(['products' => function($query) {
                $query->where('is_active', 1)
                      ->orderBy('created_at', 'desc')
                      ->limit(4); // Batasi 4 produk per kategori untuk tampilan dashboard
            }])->whereHas('products', function($query) {
                $query->where('is_active', 1);
            })->get();

            // Total statistik untuk card info
            $totalProducts = Products::where('is_active', 1)->count();
            $totalCategories = Category::whereHas('products', function($query) {
                $query->where('is_active', 1);
            })->count();
            $lowStockProducts = Products::where('is_active', 1)->where('stock', '<=', 10)->count();

            return view('dashboard', compact('categoriesWithProducts', 'totalProducts', 'totalCategories', 'lowStockProducts'));
        } catch (\Exception $e) {
            // Fallback jika terjadi error
            $categoriesWithProducts = collect();
            $totalProducts = 0;
            $totalCategories = 0;
            $lowStockProducts = 0;
            
            return view('dashboard', compact('categoriesWithProducts', 'totalProducts', 'totalCategories', 'lowStockProducts'));
        }
    }
}