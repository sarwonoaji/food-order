@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-6">Detail QR Code</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">ID</label>
            <p class="px-3 py-2 bg-gray-50 rounded border">{{ $qrcode['id'] }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Meja</label>
            <p class="px-3 py-2 bg-gray-50 rounded border">{{ $qrcode['table_number'] }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode QR</label>
            <p class="px-3 py-2 bg-gray-50 rounded border">{{ $qrcode['code'] }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <p class="px-3 py-2 bg-gray-50 rounded border">
                <span class="px-2 py-1 rounded-full text-sm font-semibold 
                    {{ $qrcode['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($qrcode['status']) }}
                </span>
            </p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Dibuat pada</label>
            <p class="px-3 py-2 bg-gray-50 rounded border">{{ $qrcode['created_at'] }}</p>
        </div>

        <div class="flex space-x-2">
            <a href="{{ route('admin.qrcodes.edit', $qrcode['id']) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                Edit
            </a>
            <a href="{{ route('admin.qrcodes.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
