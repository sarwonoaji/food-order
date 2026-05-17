<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- PENTING UNTUK MOBILE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meja Dipakai</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-orange-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl p-8 text-center w-full max-w-md">

        <div class="text-7xl mb-5">
            🍽️
        </div>

        <h1 class="text-3xl font-bold text-orange-500 mb-4">
            Meja Sedang Dipakai
        </h1>

        <p class="text-gray-500 mb-8 text-lg leading-relaxed">
            Meja <span class="font-semibold">{{ $table }}</span>
            sedang digunakan pelanggan lain.
            <br>
            Mohon cari meja kosong.
        </p>

        <!-- <a href="/"
           class="bg-orange-500 hover:bg-orange-600 active:scale-95 transition text-white px-6 py-4 rounded-2xl inline-block w-full text-lg font-semibold">

            Kembali
        </a> -->

    </div>

</body>
</html>