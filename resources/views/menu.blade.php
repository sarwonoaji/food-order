@extends('layouts.app')

@section('content')

@php

$cart = session('cart', []);

$cartCount = collect($cart)->sum('qty');

@endphp

<!-- Header -->
<div class="mb-6">

    <div class="flex items-center justify-between gap-3">

        <div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                Daftar Menu
            </h1>

            <p class="text-gray-500 mt-1 text-sm md:text-base">
                Pilih makanan favoritmu 🍜
            </p>

        </div>

        <!-- Cart + Check Order -->
        <div class="flex items-center gap-3">

            {{-- direct link to last order if exists --}}
            @if(session('last_order_id'))
                <a href="/order/{{ session('last_order_id') }}" class="btn btn-sm btn-outline hidden sm:inline-flex">Lihat Pesanan</a>
            @endif

            <div class="hidden sm:block">
                <form id="check-order-form" onsubmit="return goToOrder(event)" class="flex items-center">
                    <input type="text" id="check-order-id" placeholder="Cek pesanan (ID)" class="input input-sm input-bordered rounded-full pr-10" aria-label="Cek pesanan ID">
                    <button type="submit" class="btn btn-sm ml-2">Cek</button>
                </form>
            </div>

            <!-- Cart -->
            <a
                href="/cart"
                class="relative"
            >

            <button
                class="btn btn-circle bg-orange-500 hover:bg-orange-600 border-0 text-white shadow-lg"
            >

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5.4 5M7 13l-1.3 6.3a1 1 0 001 1.2h12.6M9 21a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z" />

                </svg>

            </button>

            @if($cartCount > 0)

            <div
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center shadow"
            >

                {{ $cartCount }}

            </div>

            @endif

        </a>

        <script>
            function goToOrder(e) {
                e.preventDefault();
                var id = document.getElementById('check-order-id').value.trim();
                if (!id) return false;
                // basic sanitize: allow only digits
                id = encodeURIComponent(id);
                window.location.href = '/order/' + id;
                return false;
            }
        </script>

    </div>

</div>

<!-- Search -->
<div class="mb-6">

    <form action="/" method="GET" class="relative">

        <input
            type="search"
            name="q"
            value="{{ isset($term) ? $term : request('q') }}"
            placeholder="Cari makanan atau minuman..."
            class="input input-bordered w-full rounded-2xl pl-12 bg-white border-gray-200 shadow-sm focus:shadow-md"
            aria-label="Cari produk"
        >

        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2.5a7.5 7.5 0 010 14.15z"/></svg>
        </button>

        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

    </form>

</div>

<!-- Category -->
<div class="flex gap-3 overflow-x-auto pb-2 mb-6 scrollbar-hide">

    <!-- Semua -->
    <a
        href="/"
        class="btn rounded-2xl whitespace-nowrap border-0
        {{ request('category') == null
            ? 'bg-orange-500 text-white'
            : 'btn-outline'
        }}"
    >
        Semua
    </a>

    <!-- Makanan -->
    <a
        href="/?category=Makanan"
        class="btn rounded-2xl whitespace-nowrap border-0
        {{ request('category') == 'Makanan'
            ? 'bg-orange-500 text-white'
            : 'btn-outline'
        }}"
    >
        Makanan
    </a>

    <!-- Minuman -->
    <a
        href="/?category=Minuman"
        class="btn rounded-2xl whitespace-nowrap border-0
        {{ request('category') == 'Minuman'
            ? 'bg-orange-500 text-white'
            : 'btn-outline'
        }}"
    >
        Minuman
    </a>

    <!-- Snack -->
    <a
        href="/?category=Snack"
        class="btn rounded-2xl whitespace-nowrap border-0
        {{ request('category') == 'Snack'
            ? 'bg-orange-500 text-white'
            : 'btn-outline'
        }}"
    >
        Snack
    </a>

</div>

<!-- Product Grid (2 cards per row) -->
<div class="grid grid-cols-2 gap-6">

    @foreach($products as $product)

    <div class="card card-compact bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition duration-200 border">

        <figure class="relative">
            @if($product->image)
                <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover">
            @else
                <div class="w-full h-44 bg-base-200 flex items-center justify-center text-sm text-muted">No Image</div>
            @endif

            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-orange-500 shadow">{{ $product->category }}</div>
        </figure>

        <div class="p-4">
            <h3 class="font-semibold text-gray-800 text-sm md:text-base line-clamp-2">{{ $product->name }}</h3>
            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>

            <div class="mt-4 flex items-center justify-between">
                <div class="text-orange-500 font-bold">Rp {{ number_format($product->price) }}</div>

                <form action="/cart/add/{{ $product->id }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-primary rounded-xl px-3 py-2">Tambah</button>
                </form>
            </div>
        </div>

    </div>

    @endforeach

</div>

<!-- Floating Cart Mobile -->
<a
    href="/cart"
    class="fixed bottom-5 right-5 md:hidden z-50"
>

    <div class="relative">

        <button
            class="btn btn-circle w-16 h-16 bg-orange-500 hover:bg-orange-600 border-0 text-white shadow-2xl"
        >
            🛒
        </button>

        @if($cartCount > 0)

        <div
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center shadow"
        >

            {{ $cartCount }}

        </div>

        @endif

    </div>

</a>
@if(session('last_order_id'))
    <a href="/order/{{ session('last_order_id') }}" class="fixed bottom-5 right-20 md:hidden z-50">
        <div class="relative">
            <button class="btn btn-circle w-14 h-14 bg-white text-orange-500 border shadow-lg">
                🧾
            </button>
        </div>
    </a>
@endif

@endsection