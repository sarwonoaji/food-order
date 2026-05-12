<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderAdminController extends Controller
{
    /**
     * List semua pesanan
     */
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function show($id)
    {
        $order = Order::with('items.product')
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);

        $order->status = $request->status;

        $order->save();

        return back()->with(
            'success',
            'Status berhasil diupdate'
        );
    }
}