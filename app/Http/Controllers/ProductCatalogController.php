<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;

class ProductCatalogController extends Controller
{
    /**
     * Display product catalog for visitors and users
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->get('category');
        $search = $request->get('search');

        $products = Products::with('category')
            ->where('is_active', 1)
            ->when($selectedCategory, function($query, $selectedCategory) {
                return $query->where('category_id', $selectedCategory);
            })
            ->when($search, function($query, $search) {
                return $query->where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('description', 'LIKE', '%'.$search.'%');
            })
            ->paginate(12);

        return view('catalog.index', compact('products', 'categories', 'selectedCategory', 'search'));
    }

    /**
     * Display product detail
     */
    public function show(Products $product)
    {
        // Only show active products
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Products::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}