<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;

        $products = Product::query()

            ->when($category, function ($query) use ($category) {

                $query->where('category', $category);
            })

            ->latest()
            ->get();

        return view('menu', compact('products', 'category'));
    }
}
