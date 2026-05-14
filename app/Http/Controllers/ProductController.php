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

        if ($request->filled('table') && !session('customer_name')) {

            session()->put('table_number', $request->table);

            return view('input-name', [
                'table' => $request->table
            ]);
}

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
                        // Keep existing batch_number for continuing order
                    } else {
                        // Clear order-related sessions for new order
                        session()->forget(['order_id', 'batch_number']);
                        
                        $order = Order::create([
                            'customer_name' => session('customer_name'),
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
                    // Keep existing batch_number for continuing order
                } else {
                    // Clear order-related sessions for new order
                    session()->forget(['order_id', 'batch_number']);
                    
                    $order = Order::create([
                        'customer_name' => session('customer_name'),
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
        ));
            }

             // simpan nama customer
    public function saveName(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'table' => 'required',
        ]);

        session()->put('customer_name', $request->customer_name);
        
        // Clear order-related sessions for new customer
        session()->forget(['order_id', 'batch_number']);

        return redirect('/?table=' . $request->table);
    }
}
