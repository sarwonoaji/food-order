@extends('layouts.app')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Detail Pesanan
    </h1>

</div>

<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6">

    <div class="grid md:grid-cols-3 gap-4">

        <div>

            <div class="text-sm text-gray-500">
                Customer
            </div>

            <div class="font-bold text-lg">
                {{ $order->customer_name }}
            </div>

        </div>

        <div>

            <div class="text-sm text-gray-500">
                Meja
            </div>

            <div class="font-bold text-lg">
                {{ $order->table_number }}
            </div>

        </div>

        <div>

            <div class="text-sm text-gray-500">
                Total
            </div>

            <div class="font-bold text-lg text-orange-500">
                Rp {{ number_format($order->total) }}
            </div>

        </div>

    </div>

</div>

<!-- Items -->
<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6">

    <h2 class="text-xl font-bold mb-5">
        Item Pesanan
    </h2>

    <div class="space-y-4">

        @foreach($order->items as $item)

        <div class="flex justify-between items-center">

            <div>

                <div class="font-semibold">
                    {{ $item->product->name }}
                </div>

                <div class="text-sm text-gray-500">
                    Qty: {{ $item->qty }}
                </div>

            </div>

            <div class="font-bold text-orange-500">
                Rp {{ number_format($item->price * $item->qty) }}
            </div>

        </div>

        @endforeach

    </div>

</div>

<!-- Update Status -->
<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

    <h2 class="text-xl font-bold mb-5">
        Update Status
    </h2>

    <form
        action="/admin/orders/{{ $order->id }}/status"
        method="POST"
    >

        @csrf

        <div class="grid md:grid-cols-2 gap-4">

            <select
                name="status"
                class="select select-bordered rounded-2xl"
            >

                <option value="MENUNGGU">
                    MENUNGGU
                </option>

                <option value="DIPROSES">
                    DIPROSES
                </option>

                <option value="DIMASAK">
                    DIMASAK
                </option>

                <option value="SIAP">
                    SIAP
                </option>

                <option value="SELESAI">
                    SELESAI
                </option>

            </select>

            <button
                class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl"
            >
                Update Status
            </button>

        </div>

    </form>

</div>

@endsection