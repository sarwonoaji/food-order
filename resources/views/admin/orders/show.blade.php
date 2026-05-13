@extends('layouts.app')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Detail Pesanan
    </h1>

</div>

@php
    $statusColor = match($order->status) {
        'MENUNGGU' => 'bg-gray-100 text-gray-800',
        'DIPROSES' => 'bg-blue-100 text-blue-800',
        'DIMASAK' => 'bg-yellow-100 text-yellow-800',
        'SIAP' => 'bg-green-100 text-green-800',
        'SELESAI' => 'bg-gray-200 text-gray-700',
        default => 'bg-gray-100 text-gray-800'
    };
@endphp

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <div class="text-sm text-gray-400">Order</div>
            <div class="text-2xl font-bold text-gray-800">#{{ $order->id }}</div>
            <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</div>
        </div>

        <div class="text-right">
            <div class="inline-flex items-center gap-3">
                <div class="px-3 py-1 rounded-full {{ $statusColor }}">
                    <span class="text-sm font-semibold">{{ $order->status }}</span>
                </div>
                <a href="/admin/orders" class="btn btn-ghost btn-sm">Kembali</a>
            </div>
        </div>
    </div>

    <div class="mt-6 grid md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <div class="text-sm text-gray-500">Customer</div>
            <div class="font-semibold text-lg text-gray-800">{{ $order->customer_name }}</div>
            <div class="mt-3 text-sm text-gray-500">Meja</div>
            <div class="font-medium text-gray-800">{{ $order->table_number }}</div>
        </div>

        <div class="text-right">
            <div class="text-sm text-gray-500">Total</div>
            <div class="text-2xl font-bold text-orange-500">Rp {{ number_format($order->total) }}</div>
            <div class="mt-2 text-sm text-gray-400">{{ $order->items->count() }} item</div>
        </div>
    </div>
</div>

<!-- Items -->

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Item Pesanan</h2>
    <div class="divide-y">
        @foreach($order->items as $item)
        <div class="py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div>
                    <div class="font-semibold text-gray-800">{{ $item->product->name }}</div>
                    <div class="text-sm text-gray-400">{{ $item->product->description ?? '' }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price) }}</div>
                <div class="font-semibold text-orange-500">Rp {{ number_format($item->price * $item->qty) }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@if($order->status !== 'SELESAI')
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold mb-4">Aksi Cepat</h2>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <form action="/admin/orders/{{ $order->id }}/status" method="POST" class="flex-1">
            @csrf
            <div class="flex gap-3 items-center">
                <label for="status" class="sr-only">Pilih status</label>
                <select id="status" name="status" class="select select-bordered rounded-lg w-full md:w-72">
                    <option value="MENUNGGU" {{ $order->status === 'MENUNGGU' ? 'selected' : '' }}>MENUNGGU</option>
                    <option value="DIPROSES" {{ $order->status === 'DIPROSES' ? 'selected' : '' }}>DIPROSES</option>
                    <option value="DIMASAK" {{ $order->status === 'DIMASAK' ? 'selected' : '' }}>DIMASAK</option>
                    <option value="SIAP" {{ $order->status === 'SIAP' ? 'selected' : '' }}>SIAP</option>
                    <option value="SELESAI" {{ $order->status === 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
                </select>

                <button class="btn bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg" type="submit">Update</button>

                <input type="hidden" name="_redirect" value="/admin/orders/{{ $order->id }}">
            </div>
        </form>

        <div class="flex items-center gap-3 md:justify-end">
            <form action="/admin/orders/{{ $order->id }}/status" method="POST" onsubmit="return confirm('Tandai pesanan ini sebagai SELESAI?')">
                @csrf
                <input type="hidden" name="status" value="SELESAI">
                <button class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Tandai Selesai</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold mb-2">Aksi Cepat</h2>
    <div class="text-sm text-gray-500">Pesanan sudah selesai. Tidak ada aksi yang tersedia.</div>
</div>
@endif

@endsection