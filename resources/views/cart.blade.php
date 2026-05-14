@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Keranjang
    </h1>

    <p class="text-gray-500 mt-1">
        Review pesanan kamu
    </p>

</div>


@if(count($cart) > 0)

@php $total = 0; @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-40">

    <!-- Items list -->
    <div class="lg:col-span-2 space-y-4">

        @foreach($cart as $item)

            @php
                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;
            @endphp

            <div class="flex gap-4 items-center bg-white rounded-2xl p-4 shadow-sm border">

                <img src="{{ asset('img/products/' . $item['image']) }}" class="w-28 h-28 rounded-xl object-cover" alt="{{ $item['name'] }}">

                <div class="flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item['description'] ?? '' }}</p>
                        </div>

                        <div class="text-right">
                            <div class="text-orange-500 font-bold">Rp {{ number_format($subtotal) }}</div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between">

                        <div class="inline-flex items-center gap-2 border rounded-full overflow-hidden">
                            <form action="/cart/remove-one/{{ $item['id'] }}" method="POST">
                                @csrf
                                <button class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                            </form>

                            <div class="px-4 py-2 bg-white text-sm">{{ $item['qty'] }}</div>

                            <form action="/cart/add/{{ $item['id'] }}" method="POST">
                                @csrf
                                <button class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                            </form>
                        </div>

                        <form action="/cart/remove/{{ $item['id'] }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-ghost text-red-500">Hapus</button>
                        </form>

                    </div>
                </div>

            </div>

        @endforeach

    </div>

    <!-- Summary -->
    <aside class="bg-white rounded-2xl p-6 shadow-sm border">

        <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>

        <div class="space-y-3 mb-4">
            <div class="flex justify-between text-sm text-gray-600">
                <span>Jumlah Item</span>
                <span>{{ collect($cart)->sum('qty') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total) }}</span>
            </div>
        </div>

        <form action="/checkout" method="POST">
            @csrf

            <!-- <div class="space-y-3">
                <label class="text-sm text-gray-700">Nama</label>
                <input type="text" name="customer_name" class="input input-bordered w-full rounded-lg" placeholder="Nama pemesan" required>

           </div> -->

            <div class="mt-6">
                <button class="btn w-full bg-orange-500 hover:bg-orange-600 text-white">Checkout — Rp {{ number_format($total) }}</button>
            </div>
        </form>

    </aside>

</div>

@else

<!-- Empty Cart -->
<div class="flex flex-col items-center justify-center py-24">

    <div class="text-7xl mb-5">
        🛒
    </div>

    <h2 class="text-2xl font-bold text-gray-800">
        Keranjang kosong
    </h2>

    <p class="text-gray-500 mt-2">
        Yuk pilih menu favoritmu dulu
    </p>

    <a
        href="/"
        class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl mt-6 px-8"
    >
        Kembali ke Menu
    </a>

</div>

@endif

@endsection