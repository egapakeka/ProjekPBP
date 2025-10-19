<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil produk aktif dengan jumlah terjual terbanyak
        $products = Products::with('category')
            ->withSum('orderItems as total_sold', 'qty')
            ->where('is_active', 1)
            ->orderByRaw('COALESCE(total_sold, 0) DESC')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        // Kirim ke view landing.blade.php
        return view('landing', compact('products'));
    }
}
