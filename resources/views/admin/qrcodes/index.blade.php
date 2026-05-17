@extends('layouts.admin')

@section('content')

@php
    // use $base provided by controller (url('/'))
    // fallback to app URL if not provided
    $base = $base ?? url('/');
@endphp

<div class="mb-6">
    <h1 class="text-2xl font-bold">QR Codes Meja</h1>
    <br>
    <div class="flex items-center gap-4 mt-3">
        <form method="GET" action="{{ route('admin.qrcodes.index') }}" class="flex items-center gap-2">
            <label for="filter" class="text-sm text-gray-600">Filter:</label>
            <select id="filter" name="filter" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                <option value="all" {{ (isset($filter) && $filter === 'all') ? 'selected' : '' }}>Semua</option>
                <option value="kosong" {{ (isset($filter) && $filter === 'kosong') ? 'selected' : '' }}>Kosong</option>
                <option value="siap" {{ (isset($filter) && $filter === 'siap') ? 'selected' : '' }}>Terpakai (Siap)</option>
                <option value="proses" {{ (isset($filter) && $filter === 'proses') ? 'selected' : '' }}>Terpakai (Proses)</option>
                <option value="memesan" {{ (isset($filter) && $filter === 'memesan') ? 'selected' : '' }}>Terpakai (Memesan)</option>
            </select>
            <noscript><button type="submit" class="btn btn-sm">Terapkan</button></noscript>
        </form>

        <a href="/admin/qrcodes/create" class="ml-auto bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
            Tambah
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse($qrcodes as $qrcode)
        @php
            $table = $qrcode->table_number;
            $url = rtrim($base, '/') . '/aK92LpQwEr/' . urlencode($table);
            // use explicit png format to avoid content-type issues
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=png&data=' . urlencode($url);
            $info = $tablesStatus[$table] ?? ['occupied' => false];
        @endphp

        <div class="bg-white rounded-xl p-4 shadow-sm border flex flex-col items-center">
            <div class="text-lg font-semibold mb-2">Meja {{ $table }}</div>
            <div class="mb-2">
                @if($info['occupied'])
                    <span class="badge badge-error">Terpakai ({{ $info['status'] }})</span>
                @else
                    <span class="badge badge-success">Kosong</span>
                @endif
            </div>
            <img src="{{ $qrUrl }}" alt="QR {{ $table }}" class="mb-3 w-48 h-48 object-contain">
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                <a href="{{ $qrUrl }}" target="_blank" class="btn btn-sm">Unduh</a>
                <a href="{{ route('admin.qrcodes.edit', $qrcode->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.qrcodes.destroy', $qrcode->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Hapus QR meja {{ $table }}?')">Hapus</button>
                </form>
                @if($info['occupied'] && !empty($info['order_id']))
                    <a href="/admin/orders/{{ $info['order_id'] }}" class="btn btn-sm">Lihat Pesanan</a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl p-6 shadow-sm border text-center">
            Kosong.
        </div>
    @endforelse
</div>

@endsection
