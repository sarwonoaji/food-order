@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold mb-6">Tambah QR Code Baru</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Terjadi Kesalahan!</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
    @endif

    <form action="{{ route('admin.qrcodes.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label for="table_number" class="block text-gray-700 text-sm font-bold mb-2">
                Nomor Meja
            </label>
            <input type="text" id="table_number" name="table_number" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 @error('table_number') border-red-500 @enderror"
                   value="{{ old('table_number') }}" placeholder="Contoh: A1" required>
            @error('table_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">
                Kode QR
            </label>
            <input type="text" id="code" name="code" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 @error('code') border-red-500 @enderror"
                   value="{{ old('code') }}" placeholder="Contoh: QR-A1-001" required>
            @error('code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                Status
            </label>
            <select id="status" name="status" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 @error('status') border-red-500 @enderror"
                    required>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.qrcodes.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
