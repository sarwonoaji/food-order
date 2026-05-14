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

<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <div class="navbar bg-orange-500 text-white shadow-md">
        
        <div class="container mx-auto flex items-center justify-between">

            <!-- Left -->
            <div>
                <a class="text-2xl font-bold tracking-wide">
                    Food Order
                </a>
            </div>

            <!-- Right Menu -->
            <div>
                <ul class="menu menu-horizontal gap-2">

                    <li>
                        <a href="/admin/qrcodes"
                            class="bg-white text-orange-500 hover:bg-orange-100 rounded-full px-5 font-semibold">
                            QR
                        </a>
                    </li>

                    <li>
                        <a href="/admin/products"
                            class="bg-white text-orange-500 hover:bg-orange-100 rounded-full px-5 font-semibold">
                            Product
                        </a>
                    </li>

                    <li>
                        <a href="/admin/orders"
                            class="bg-white text-orange-500 hover:bg-orange-100 rounded-full px-5 font-semibold">
                            Order
                        </a>
                    </li>

                </ul>
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