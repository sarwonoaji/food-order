@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">

    <div>
        <h1 class="text-3xl font-bold">Produk</h1>
        <p class="text-sm text-muted">Kelola daftar produk menu Anda.</p>
    </div>

    <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="flex-1 md:flex-none">
            <form action="" method="GET">
                <div class="form-control">
                    <div class="input-group">
                        <input type="search" name="q" placeholder="Cari produk..." class="input input-bordered" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-square">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2.5a7.5 7.5 0 010 14.15z"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <a href="/admin/products/create" class="btn btn-warning">Tambah Produk</a>
    </div>

</div>

@if($products->isEmpty())
    <div class="card bg-base-100 p-6 text-center">
        <p class="text-lg">Belum ada produk. Tambahkan produk baru untuk mulai menjual.</p>
        <div class="mt-4"><a href="/admin/products/create" class="btn btn-primary">Tambah Produk</a></div>
    </div>
@else

    <div class="overflow-x-auto">

        <table class="table w-full bg-base-100 shadow-sm">

            <thead>
                <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($products as $product)

                <tr class="hover">

                    <td class="w-20">
                        @if($product->image)
                            <img src="{{ asset('img/products/' . $product->image) }}" class="w-16 h-16 rounded-lg object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-base-200 flex items-center justify-center text-sm text-muted">No Image</div>
                        @endif
                    </td>

                    <td class="font-medium">{{ $product->name }}</td>

                    <td>
                        <div class="badge badge-outline">{{ $product->category }}</div>
                    </td>

                    <td>Rp {{ number_format($product->price) }}</td>

                    <td class="text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-info">Edit</a>
                            <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error">Hapus</button>
                            </form>
                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endif

@endsection