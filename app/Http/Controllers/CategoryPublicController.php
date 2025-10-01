<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryPublicController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('catalog.categories', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()->where('is_active', 1)->paginate(12);
        return view('catalog.category_products', compact('category', 'products'));
    }
}
