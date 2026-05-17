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

        // =====================================================
        // HANDLE QR TABLE
        // =====================================================
        if ($request->filled('table')) {

            $table = $request->table;

            session()->put('table_number', $table);

            $orderId = session('order_id');

            // cek order aktif di meja
            $openOrder = Order::where('table_number', $table)
                ->where('status', '!=', 'SELESAI')
                ->latest()
                ->first();

            // =====================================================
            // JIKA USER MASIH PUNYA SESSION ORDER
            // =====================================================
            if ($orderId) {

                $myOrder = Order::find($orderId);

                // jika order milik sendiri & belum selesai
                if (
                    $myOrder &&
                    $openOrder &&
                    $myOrder->id == $openOrder->id &&
                    $myOrder->status != 'SELESAI'
                ) {

                    // lanjutkan order lama
                    session()->put('order_id', $myOrder->id);
                    session()->put('last_order_id', $myOrder->id);

                } else {

                    // session invalid
                    session()->forget([
                        'order_id',
                        'batch_number'
                    ]);

                    // meja sedang dipakai customer lain
                    if ($openOrder) {

                        return view('table-used', [
                            'table' => $table
                        ]);
                    }
                }

            } else {

                // =====================================================
                // USER BARU / DEVICE BARU
                // =====================================================

                // jika meja sedang dipakai
                if ($openOrder) {

                    return view('table-used', [
                        'table' => $table
                    ]);
                }
            }

            // =====================================================
            // JIKA BELUM ADA NAMA CUSTOMER
            // =====================================================
            if (!session('customer_name')) {

                return view('input-name', [
                    'table' => $table
                ]);
            }

            // =====================================================
            // BUAT ORDER BARU JIKA BELUM ADA
            // =====================================================
            if (!session('order_id')) {

                $newOrder = Order::create([
                    'customer_name' => session('customer_name'),
                    'table_number' => $table,
                    'total' => 0,
                    'status' => 'MEMESAN',
                ]);

                session()->put('order_id', $newOrder->id);
                session()->put('last_order_id', $newOrder->id);
            }
        }

        // =====================================================
        // BEST SELLER
        // =====================================================
        $bestSellerIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->pluck('product_id');

        // =====================================================
        // PRODUCTS
        // =====================================================
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

    // =====================================================
    // SIMPAN NAMA CUSTOMER
    // =====================================================
    public function saveName(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'table' => 'required',
        ]);

        session()->put('customer_name', $request->customer_name);

        // reset order lama
        session()->forget([
            'order_id',
            'batch_number'
        ]);

        return redirect('/?table=' . $request->table);
    }

    public function scanTable($table, Request $request)
    {
        $request->merge([
            'table' => $table
        ]);

        return $this->index($request);
    }
}