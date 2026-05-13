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

        // if there's an open order in session, persist the item to the order immediately
        $orderId = session('order_id');
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $orderItem = OrderItem::where('order_id', $orderId)->where('product_id', $product->id)->first();

                if ($orderItem) {
                    $orderItem->qty = $orderItem->qty + 1;
                    $orderItem->save();
                } else {
                    OrderItem::create([
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                        'qty' => 1,
                        'price' => $product->price,
                        'note' => null,
                    ]);
                }
            }
        }

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

        // also remove from any open order
        $orderId = session('order_id');
        if ($orderId) {
            OrderItem::where('order_id', $orderId)->where('product_id', $id)->delete();
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


        // If there's an open order in session, finalize it. Otherwise create new order.
        $orderId = session('order_id');

        if ($orderId) {
            $order = Order::with('items')->find($orderId);

            // compute total from persisted order items (fallback to session cart)
            if ($order && $order->items->count() > 0) {
                $total = 0;
                foreach ($order->items as $it) {
                    $total += $it->price * $it->qty;
                }
            } else {
                $total = 0;
                foreach($cart as $item) {
                    $total += $item['price'] * $item['qty'];
                }
            }

            $order->customer_name = $request->customer_name ?? $order->customer_name;
            $order->table_number = session('table_number') ?? $request->table_number;
            $order->total = $total;
            $order->status = 'SELESAI';
            $order->save();

        } else {
            $total = 0;

            foreach($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total' => $total,
                'status' => 'SELESAI',
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
        }

        DB::commit();

        // store last order id so front-end can link to status
        session()->put('last_order_id', $order->id);

        // clear only the cart; keep order_id/table_number in session so
        // the customer can track status (kasir/kitchen will progress it)
        session()->forget('cart');

        return redirect('/order/' . $order->id)
            ->with('success', 'Pesanan terkirim ke kasir. Silakan pantau status pesanan.');

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

    public function removeOne($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = max(0, $cart[$id]['qty'] - 1);

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        // update persisted order item if exists
        $orderId = session('order_id');
        if ($orderId) {
            $orderItem = OrderItem::where('order_id', $orderId)->where('product_id', $id)->first();
            if ($orderItem) {
                $orderItem->qty = max(0, $orderItem->qty - 1);
                if ($orderItem->qty <= 0) {
                    $orderItem->delete();
                } else {
                    $orderItem->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Jumlah item diperbarui');
    }
}