<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;
        $term = $request->q;

        // If a table param is present (scanned QR), create/open an order and set session
        if ($request->filled('table')) {
            $table = $request->table;
            session()->put('table_number', $table);

            $orderId = session('order_id');

            if ($orderId) {
                $existing = Order::find($orderId);
                // if the session order is missing, closed, or belongs to a different table,
                // try to find an existing open order for this table; otherwise create new
                if (!$existing || $existing->status === 'SELESAI' || $existing->table_number !== $table) {
                    $open = Order::where('table_number', $table)
                        ->where('status', '!=', 'SELESAI')
                        ->latest()
                        ->first();

                    if ($open) {
                        session()->put('order_id', $open->id);
                        session()->put('last_order_id', $open->id);
                    } else {
                        $order = Order::create([
                            'customer_name' => null,
                            'table_number' => $table,
                            'total' => 0,
                            'status' => 'MENUNGGU',
                        ]);

                        session()->put('order_id', $order->id);
                        session()->put('last_order_id', $order->id);
                    }
                }
            } else {
                // no order in session: try to reuse an open order for this table
                $open = Order::where('table_number', $table)
                    ->where('status', '!=', 'SELESAI')
                    ->latest()
                    ->first();

                if ($open) {
                    session()->put('order_id', $open->id);
                    session()->put('last_order_id', $open->id);
                } else {
                    $order = Order::create([
                        'customer_name' => null,
                        'table_number' => $table,
                        'total' => 0,
                        'status' => 'MENUNGGU',
                    ]);

                    session()->put('order_id', $order->id);
                    session()->put('last_order_id', $order->id);
                }
            }
        }

        //best seller
        $bestSellerIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->pluck('product_id');

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

        return view('menu', compact(
            'products',
            'category',
            'term',
            'bestSellerIds'
        ));;
            }
}
