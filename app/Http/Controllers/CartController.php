<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart', compact('cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            $cart[$id]['qty']++;

        } else {

            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Produk dihapus');
    }

    public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if(count($cart) == 0) {

        return redirect('/cart')
            ->with('error', 'Keranjang kosong');
    }

    DB::beginTransaction();

    try {

        $total = 0;

        foreach($cart as $item) {

            $total += $item['price'] * $item['qty'];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'total' => $total,
            'status' => 'MENUNGGU',
        ]);

        foreach($cart as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'note' => null,
            ]);
        }

        DB::commit();

        // store last order id so front-end can link to status
        session()->put('last_order_id', $order->id);

        session()->forget('cart');

        return redirect('/order/' . $order->id)
            ->with('success', 'Pesanan berhasil dibuat');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }


}
public function showOrder($id)
{
    $order = Order::with('items.product')->findOrFail($id);

    return view('order-status', compact('order'));
}
}