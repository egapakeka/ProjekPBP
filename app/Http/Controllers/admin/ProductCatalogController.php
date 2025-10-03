<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    /**
     * Menampilkan katalog produk dengan search & filter kategori
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedCategory = $request->input('category');

        $query = Product::with('category')
            ->where('is_active', 1);

        // filter berdasarkan pencarian nama/desc
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // filter berdasarkan kategori
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12);

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Menampilkan detail produk + produk terkait
     */
    public function show(Product $product)
    {
        // cek kalau produk nonaktif
        if (!$product->is_active) {
            abort(404);
        }

        // Ambil produk lain dari kategori yang sama (kecuali dirinya)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->latest()
            ->take(4)
            ->get();

        return view('catalog.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
