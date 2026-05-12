@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="card bg-base-100 shadow-xl">

        <div class="card-body">

            <h2 class="card-title text-2xl mb-5">
                Tambah Produk
            </h2>

            <form
                action="/admin/products"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="form-control mb-4">

                    <label class="label">
                        <span class="label-text">Nama Produk</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="input input-bordered"
                    >

                </div>

                <div class="form-control mb-4">

                    <label class="label">
                        <span class="label-text">Kategori</span>
                    </label>

                    <input
                        type="text"
                        name="category"
                        class="input input-bordered"
                    >

                </div>

                <div class="form-control mb-4">

                    <label class="label">
                        <span class="label-text">Harga</span>
                    </label>

                    <input
                        type="number"
                        name="price"
                        class="input input-bordered"
                    >

                </div>

                <div class="form-control mb-4">

                    <label class="label">
                        <span class="label-text">Deskripsi</span>
                    </label>

                    <textarea
                        name="description"
                        class="textarea textarea-bordered"
                    ></textarea>

                </div>

                <div class="form-control mb-5">

                    <label class="label">
                        <span class="label-text">Gambar</span>
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="file-input file-input-bordered"
                    >

                </div>

                <button class="btn btn-warning w-full">
                    Simpan Produk
                </button>

            </form>

        </div>

    </div>

</div>

@endsection