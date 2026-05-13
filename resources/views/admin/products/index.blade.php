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
                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-ghost flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150" title="Edit {{ $product->name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h6m-6 4h6M5 7h.01M5 11h.01M5 15h.01M5 19h.01"/></svg>
                                <span class="hidden sm:inline">Edit</span>
                            </a>

                            <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-red-600 transition-colors duration-150" title="Hapus {{ $product->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endif

<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection