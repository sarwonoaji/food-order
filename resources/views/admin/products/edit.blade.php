@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="card bg-base-100 shadow-xl">

        <div class="card-body">

            <h2 class="card-title text-2xl mb-5">
                Edit Produk
            </h2>
                    <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="alert alert-error mb-4">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
                                    <span>Periksa kembali input Anda.</span>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="form-control">
                                <label class="label"><span class="label-text font-semibold text-sm">Nama Produk</span></label>
                                <input type="text" name="name" class="input input-bordered input-lg w-full bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-200" placeholder="Contoh: Nasi Goreng" aria-label="Nama Produk" value="{{ old('name', $product->name) }}">
                                @error('name') <p class="text-sm text-error mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-semibold text-sm">Kategori</span></label>
                                <select name="category" class="select select-bordered select-lg w-full bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-200" aria-label="Kategori">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Makanan" {{ (old('category', $product->category) == 'Makanan') ? 'selected' : '' }}>Makanan</option>
                                    <option value="Minuman" {{ (old('category', $product->category) == 'Minuman') ? 'selected' : '' }}>Minuman</option>
                                    <option value="Snack" {{ (old('category', $product->category) == 'Snack') ? 'selected' : '' }}>Snack</option>
                                </select>
                                @error('category') <p class="text-sm text-error mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-semibold text-sm">Harga</span></label>
                                <input type="number" name="price" class="input input-bordered input-lg w-full bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-200" placeholder="10000" aria-label="Harga" value="{{ old('price', $product->price) }}">
                                @error('price') <p class="text-sm text-error mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-semibold text-sm">Ganti Gambar</span></label>
                                <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full bg-white text-gray-800" aria-label="Ganti gambar produk">
                                @error('image') <p class="text-sm text-error mt-1">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <div class="form-control mt-4">
                            <label class="label"><span class="label-text font-semibold text-sm">Deskripsi</span></label>
                            <textarea name="description" class="textarea textarea-bordered min-h-[120px] p-3 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-200" placeholder="Deskripsi singkat produk (mis. bahan, porsi, catatan)" aria-label="Deskripsi">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="text-sm text-error mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="label"><span class="label-text">Gambar Saat Ini</span></label>
                            @if($product->image)
                                <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}" class="mb-3 w-48 h-auto object-cover rounded">
                            @else
                                <p class="text-sm text-muted">Tidak ada gambar</p>
                            @endif
                        </div>

                        <div class="form-control mt-4">

                        <label class="label cursor-pointer justify-start gap-4">

                            <span class="label-text font-semibold text-sm">
                                Status Produk
                            </span>

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                 class="toggle bg-gray-300 border-gray-300 checked:bg-orange-500 checked:border-orange-500"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            />

                            <span class="text-sm text-gray-500">
                                Aktif
                            </span>

                        </label>

                    </div>

                        <div class="mt-6 flex justify-center">

                        <button
                            class="h-10 px-5 bg-orange-500 hover:bg-orange-600 active:scale-95 text-white text-sm font-semibold rounded-2xl shadow-sm transition-all duration-150 border-0"
                        >
                            Update Produk
                        </button>

                    </div>

                    </form>

        </div>

    </div>

</div>

@endsection
