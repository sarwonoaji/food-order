<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Masuk</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-8">

        <div class="text-center mb-6">

            <h1 class="text-3xl font-bold text-orange-500">
                Food Order
            </h1>

            <p class="text-gray-500 mt-2">
                Masukkan nama sebelum memesan
            </p>

        </div>

        <form action="/save-name" method="POST">

            @csrf

            <input type="hidden" name="table" value="{{ $table }}">

            <div class="mb-5">

                <label class="block text-sm font-semibold mb-2">
                    Nama Customer
                </label>

                <input
                    type="text"
                    name="customer_name"
                    placeholder="Contoh: Budi"
                    class="input input-bordered w-full rounded-2xl"
                    required
                >

            </div>

            <button
                class="btn w-full bg-orange-500 hover:bg-orange-600 text-white border-0 rounded-2xl"
            >
                Mulai Pesan
            </button>

        </form>

    </div>

</body>
</html>