@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">

    <h1 class="text-3xl font-bold">
        Produk
    </h1>

    <a href="/admin/products/create" class="btn btn-warning">
        Tambah Produk
    </a>

</div>

<div class="overflow-x-auto">

    <table class="table bg-base-100 shadow-lg">

        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($products as $product)

            <tr>

                <td>
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        class="w-16 h-16 rounded-lg object-cover"
                    >
                </td>

                <td>{{ $product->name }}</td>

                <td>
                    <div class="badge badge-warning">
                        {{ $product->category }}
                    </div>
                </td>

                <td>
                    Rp {{ number_format($product->price) }}
                </td>

                <td class="flex gap-2">

                    <a
                        href="/admin/products/{{ $product->id }}/edit"
                        class="btn btn-info btn-sm"
                    >
                        Edit
                    </a>

                    <form
                        action="/admin/products/{{ $product->id }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-error btn-sm">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection