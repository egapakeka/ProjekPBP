<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil beberapa produk (misalnya 4 produk terbaru)
        $products = Products::latest()->take(4)->get();

        // Kirim ke view landing.blade.php
        return view('landing', compact('products'));
    }
}
