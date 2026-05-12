@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Pesanan Masuk
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola pesanan customer
        </p>

    </div>

</div>

<div class="space-y-4">

    @foreach($orders as $order)

    <div
        class="bg-white rounded-3xl shadow-md border border-gray-100 p-5"
    >

        <div class="flex items-start justify-between gap-4">

            <div>

                <div class="text-sm text-gray-500">
                    Order ID
                </div>

                <div class="text-2xl font-bold text-gray-800">
                    #{{ $order->id }}
                </div>

            </div>

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

                <div class="badge {{ $statusColor }} text-white p-4">

                    {{ $order->status }}

                </div>

            </div>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">

            <div>

                <div class="text-sm text-gray-500">
                    Customer
                </div>

                <div class="font-semibold">
                    {{ $order->customer_name }}
                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">
                    Meja
                </div>

                <div class="font-semibold">
                    {{ $order->table_number }}
                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">
                    Total
                </div>

                <div class="font-bold text-orange-500">
                    Rp {{ number_format($order->total) }}
                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">
                    Waktu
                </div>

                <div class="font-semibold">
                    {{ $order->created_at->format('H:i') }}
                </div>

            </div>

        </div>

        <div class="mt-6 flex justify-end">

            <a
                href="/admin/orders/{{ $order->id }}"
                class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl"
            >
                Detail Pesanan
            </a>

        </div>

    </div>

    @endforeach

</div>

@endsection