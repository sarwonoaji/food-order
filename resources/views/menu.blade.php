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

    </div>

</div>

<!-- Search -->
<div class="mb-6">

    <div class="relative">

        <input
            type="text"
            placeholder="Cari makanan atau minuman..."
            class="input input-bordered w-full rounded-2xl pl-12 bg-white border-gray-200 shadow-sm"
        >

        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">

            🔍

        </div>

    </div>

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

<!-- Product Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

    @foreach($products as $product)

    <div
        class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 border border-gray-100"
    >

        <!-- Image -->
        <div class="relative">

            @if($product->image)

            <img
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="w-full h-40 object-cover"
            >

            @else

            <img
                src="https://placehold.co/600x400?text=No+Image"
                alt="no image"
                class="w-full h-40 object-cover"
            >

            @endif

            <!-- Category Badge -->
            <div
                class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-orange-500 shadow"
            >
                {{ $product->category }}
            </div>

        </div>

        <!-- Body -->
        <div class="p-4">

            <h2 class="font-bold text-gray-800 text-sm md:text-base line-clamp-1">
                {{ $product->name }}
            </h2>

            <p class="text-gray-500 text-xs mt-1 line-clamp-2 min-h-[32px]">
                {{ $product->description }}
            </p>

            <!-- Footer -->
            <div class="mt-4 flex items-center justify-between">

                <div>

                    <div class="text-orange-500 font-bold text-sm md:text-lg">
                        Rp {{ number_format($product->price) }}
                    </div>

                </div>

                <form action="/cart/add/{{ $product->id }}" method="POST">

                    @csrf

                    <button
                        class="w-10 h-10 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center shadow-lg transition"
                    >
                        +
                    </button>

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

@endsection