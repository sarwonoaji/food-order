@php

$cart = session('cart', []);

$cartCount = count($cart);

@endphp

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Food Order</title>
</head>

<body class="bg-white min-h-screen">

    <!-- Navbar -->
    <div class="navbar bg-orange-500 text-white shadow-md">

        <div class="container mx-auto">

            <div class="flex-1">

                <a class="text-2xl font-bold tracking-wide">
                    Food Order
                </a>

            </div>
            
        </div>

    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 py-6">

       @if(session('success'))

            <div class="alert alert-success mb-5 shadow-md">

            {{ session('success') }}

        </div>

        @endif

        @if(session('error'))

        <div class="alert alert-error mb-5 shadow-md">

            {{ session('error') }}

        </div>

        @endif

        @yield('content')

    </div>

</body>

</html>