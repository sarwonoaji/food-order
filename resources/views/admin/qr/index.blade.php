@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold">QR Codes Meja</h1>
    <p class="text-sm text-gray-500">Gunakan QR ini untuk setiap meja. QR mengarah ke link scan yang membuka meja di aplikasi.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($tables as $table)
    @php
        $url = $base . '/?table=' . urlencode($table);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($url);
    @endphp

    <div class="bg-white rounded-xl p-4 shadow-sm border flex flex-col items-center">
        <div class="text-lg font-semibold mb-2">Meja {{ $table }}</div>
        @php
            $info = $tablesStatus[$table] ?? ['occupied' => false];
        @endphp
        <div class="mb-2">
            @if($info['occupied'])
                <span class="badge badge-error">Terpakai ({{ $info['status'] }})</span>
            @else
                <span class="badge badge-success">Kosong</span>
            @endif
        </div>
        <img src="{{ $qrUrl }}" alt="QR {{ $table }}" class="mb-3 w-48 h-48 object-contain">
        <div class="flex gap-2">
            <a href="{{ $qrUrl }}" target="_blank" class="btn btn-sm">Unduh</a>
            <button onclick="window.open('{{ $url }}','_blank')" class="btn btn-sm btn-ghost">Buka</button>
            @if($info['occupied'] && !empty($info['order_id']))
                <a href="/admin/orders/{{ $info['order_id'] }}" class="btn btn-sm">Lihat Pesanan</a>
            @endif
        </div>
    </div>

    @endforeach
</div>

@endsection
