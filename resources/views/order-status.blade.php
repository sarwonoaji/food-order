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

      {{-- <div class="mt-4">
        <a href="/" class="btn bg-orange-500 hover:bg-orange-600 border-0 text-white rounded-2xl px-4">Kembali ke Menu</a>
    </div> --}}

</div>

<!-- Order Info -->
@php
    $statusPill = match($order->status) {
        'MENUNGGU' => 'bg-orange-100 text-orange-700',
        'DIPROSES' => 'bg-blue-100 text-blue-700',
        'DIMASAK' => 'bg-yellow-100 text-yellow-800',
        'SIAP' => 'bg-green-100 text-green-800',
        'SELESAI' => 'bg-gray-200 text-gray-700',
        default => 'bg-gray-100 text-gray-800'
    };
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <div class="text-sm text-gray-400">Order</div>
            <div class="flex items-baseline gap-3">
                <div class="text-2xl font-bold text-gray-800">#{{ $order->id }}</div>
                <div class="text-sm text-gray-500">• {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="mt-2 text-sm text-gray-600">{{ $order->customer_name }} • Meja {{ $order->table_number }}</div>
        </div>

        <div class="text-right">
            <div class="inline-flex items-center gap-3">
                <div class="px-3 py-1 rounded-full {{ $statusPill }} font-semibold">{{ $order->status }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Progress (horizontal) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold">Progress Pesanan</h2>
        <div class="text-sm text-gray-500">Status saat ini: <span class="font-semibold text-gray-700">{{ $order->status }}</span></div>
    </div>

    @php
        $steps = [
            ['key' => 'MENUNGGU', 'label' => 'Diterima', 'icon' => '✓'],
            ['key' => 'DIPROSES', 'label' => 'Diproses', 'icon' => '🧾'],
            ['key' => 'DIMASAK', 'label' => 'Dimakas', 'icon' => '🍳'],
            ['key' => 'SIAP', 'label' => 'Siap', 'icon' => '🍽️'],
            ['key' => 'SELESAI', 'label' => 'Selesai', 'icon' => '✅'],
        ];
        $current = $order->status;
        $keys = array_column($steps, 'key');
    @endphp

    <div class="flex gap-4 items-center">
        @foreach($steps as $s)
            @php
                $posS = array_search($s['key'], $keys);
                $posCurrent = array_search($current, $keys);
                $done = ($posCurrent !== false) && ($posS !== false) && ($posS <= $posCurrent);
            @endphp
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $done ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-500' }}">{!! $s['icon'] !!}</div>
                    <div>
                        <div class="text-sm font-semibold {{ $done ? 'text-gray-800' : 'text-gray-500' }}">{{ $s['label'] }}</div>
                        <div class="text-xs text-gray-400">{{ $s['key'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Items -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold">Detail Pesanan</h2>
        <div class="text-sm text-gray-500">{{ $order->items->count() }} item</div>
    </div>

    <div class="divide-y">
        @foreach($order->items as $item)
        <div class="py-4 flex items-center justify-between">
            <div>
                <div class="font-semibold text-gray-800">{{ $item->product->name }}</div>
                <div class="text-sm text-gray-400">Qty: {{ $item->qty }}</div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Rp {{ number_format($item->price) }} x {{ $item->qty }}</div>
                <div class="font-semibold text-orange-500">Rp {{ number_format($item->price * $item->qty) }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="border-t mt-6 pt-4 flex items-center justify-between">
        <div>
            <div class="text-sm text-gray-500">Subtotal</div>
            <div class="text-sm text-gray-400">(Termasuk pajak jika ada)</div>
        </div>
        <div class="text-2xl font-bold text-orange-500">Rp {{ number_format($order->total) }}</div>
    </div>
</div>

@endsection