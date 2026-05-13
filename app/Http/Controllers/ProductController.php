<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;
        $term = $request->q;

        $products = Product::query()

            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })

            ->when($term, function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%")
                      ->orWhere('category', 'like', "%{$term}%");
                });
            })

            ->latest()
            ->get();

        return view('menu', compact('products', 'category', 'term'));
    }
}
