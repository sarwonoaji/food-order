@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Status Pesanan
    </h1>

    <p class="text-gray-500 mt-2">
        Pantau pesanan kamu secara realtime 🍜
    </p>

    <div class="mt-4">
        <a href="/?table={{ $order->table_number }}" class="btn btn-warning">Tambah Pesanan</a>
    </div>

      <div class="mt-4">
        <a href="/" class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl px-4">Kembali ke Menu</a>
    </div>

</div>

<!-- Order Info -->
<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6">

    <div class="flex items-start justify-between gap-4">

        <div>

            <div class="text-sm text-gray-500">
                Order ID
            </div>

            <div class="text-xl font-bold text-gray-800">
                #{{ $order->id }}
            </div>

        </div>

        <!-- Status Badge -->
        <div>

            @php

            $statusColor = match($order->status) {
                'MENUNGGU' => 'badge-neutral',
                'DIPROSES' => 'badge-info',
                'DIMASAK' => 'badge-warning',
                'SIAP' => 'badge-success',
                'SELESAI' => 'badge-success',
                default => 'badge-neutral'
            };

            @endphp

            <div class="badge {{ $statusColor }} text-white p-4 text-sm">

                {{ $order->status }}

            </div>

        </div>

    </div>

    <!-- Customer -->
    <div class="mt-6 grid grid-cols-2 gap-4">

        <div>

            <div class="text-sm text-gray-500">
                Customer
            </div>

            <div class="font-semibold text-gray-800">
                {{ $order->customer_name }}
            </div>

        </div>

        <div>

            <div class="text-sm text-gray-500">
                Nomor Meja
            </div>

            <div class="font-semibold text-gray-800">
                {{ $order->table_number }}
            </div>

        </div>

    </div>

</div>

<!-- Progress -->
<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6">

    <h2 class="text-xl font-bold mb-6">
        Progress Pesanan
    </h2>

    <div class="space-y-5">

        <!-- MENUNGGU -->
        <div class="flex items-center gap-4">

            <div class="
                w-10 h-10 rounded-full flex items-center justify-center
                {{ in_array($order->status, ['MENUNGGU','DIPROSES','DIMASAK','SIAP','SELESAI'])
                    ? 'bg-orange-500 text-white'
                    : 'bg-gray-200'
                }}
            ">
                ✓
            </div>

            <div>
                <div class="font-semibold">
                    Pesanan diterima
                </div>

                <div class="text-sm text-gray-500">
                    Menunggu konfirmasi restoran
                </div>
            </div>

        </div>

        <!-- DIPROSES -->
        <div class="flex items-center gap-4">

            <div class="
                w-10 h-10 rounded-full flex items-center justify-center
                {{ in_array($order->status, ['DIPROSES','DIMASAK','SIAP','SELESAI'])
                    ? 'bg-orange-500 text-white'
                    : 'bg-gray-200'
                }}
            ">
                ✓
            </div>

            <div>
                <div class="font-semibold">
                    Pesanan diproses
                </div>

                <div class="text-sm text-gray-500">
                    Kasir sedang memproses pesanan
                </div>
            </div>

        </div>

        <!-- DIMASAK -->
        <div class="flex items-center gap-4">

            <div class="
                w-10 h-10 rounded-full flex items-center justify-center
                {{ in_array($order->status, ['DIMASAK','SIAP','SELESAI'])
                    ? 'bg-orange-500 text-white'
                    : 'bg-gray-200'
                }}
            ">
                🍳
            </div>

            <div>
                <div class="font-semibold">
                    Sedang dimasak
                </div>

                <div class="text-sm text-gray-500">
                    Chef sedang menyiapkan makanan
                </div>
            </div>

        </div>

        <!-- SIAP -->
        <div class="flex items-center gap-4">

            <div class="
                w-10 h-10 rounded-full flex items-center justify-center
                {{ in_array($order->status, ['SIAP','SELESAI'])
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-200'
                }}
            ">
                🍽️
            </div>

            <div>
                <div class="font-semibold">
                    Pesanan siap
                </div>

                <div class="text-sm text-gray-500">
                    Pesanan siap diambil / diantar
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Items -->
<div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

    <h2 class="text-xl font-bold mb-6">
        Detail Pesanan
    </h2>

    <div class="space-y-4">

        @foreach($order->items as $item)

        <div class="flex items-center justify-between">

            <div>

                <div class="font-semibold text-gray-800">
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

    <!-- Total -->
    <div class="border-t mt-6 pt-4 flex justify-between">

        <div class="font-semibold text-lg">
            Total
        </div>

        <div class="text-2xl font-bold text-orange-500">
            Rp {{ number_format($order->total) }}
        </div>

    </div>

</div>

@endsection