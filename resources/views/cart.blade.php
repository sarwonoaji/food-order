@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Keranjang
    </h1>

    <p class="text-gray-500 mt-1">
        Review pesanan kamu 🍜
    </p>

</div>

@if(count($cart) > 0)

@php
    $total = 0;
@endphp

<!-- Cart Items -->
<div class="space-y-4 pb-44">

    @foreach($cart as $item)

    @php
        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;
    @endphp

    <div
        class="bg-white rounded-3xl p-4 shadow-md border border-gray-100 flex gap-4"
    >

        <!-- Image -->
        <img
            src="{{ asset('storage/' . $item['image']) }}"
            class="w-24 h-24 rounded-2xl object-cover"
        >

        <!-- Content -->
        <div class="flex-1 flex flex-col justify-between">

            <div>

                <h2 class="font-bold text-gray-800 text-lg line-clamp-1">
                    {{ $item['name'] }}
                </h2>

                <div class="text-sm text-gray-500 mt-1">
                    Qty: {{ $item['qty'] }}
                </div>

            </div>

            <div class="flex items-center justify-between mt-3">

                <div class="text-orange-500 font-bold text-lg">
                    Rp {{ number_format($subtotal) }}
                </div>

                <form
                    action="/cart/remove/{{ $item['id'] }}"
                    method="POST"
                >

                    @csrf

                    <button
                        class="btn btn-sm bg-red-500 hover:bg-red-600 border-0 text-white rounded-xl"
                    >
                        Hapus
                    </button>

                </form>

            </div>

        </div>

    </div>

    @endforeach

</div>

<!-- Checkout Form -->
<div class="bg-white rounded-3xl p-5 shadow-md border border-gray-100 mb-40">

    <form action="/checkout" method="POST">

        @csrf

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Informasi Pemesan
        </h2>

        <div class="space-y-4">

            <!-- Nama -->
            <div>

                <label class="font-semibold text-sm text-gray-700">
                    Nama Customer
                </label>

                <input
                    type="text"
                    name="customer_name"
                    class="input input-bordered w-full mt-2 rounded-2xl"
                    placeholder="Masukkan nama customer"
                >

            </div>

            <!-- Meja -->
            <div>

                <label class="font-semibold text-sm text-gray-700">
                    Nomor Meja
                </label>

                <input
                    type="text"
                    name="table_number"
                    class="input input-bordered w-full mt-2 rounded-2xl"
                    placeholder="Contoh: A1"
                >

            </div>

        </div>

        <!-- Bottom Checkout -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-2xl p-4"
        >

            <div class="container mx-auto flex items-center justify-between gap-4">

                <div>

                    <div class="text-sm text-gray-500">
                        Total Pembayaran
                    </div>

                    <div class="text-2xl font-bold text-orange-500">
                        Rp {{ number_format($total) }}
                    </div>

                </div>

                <button
                    class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl px-8"
                >
                    Checkout
                </button>

            </div>

        </div>

    </form>

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