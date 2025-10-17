<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - FAQ</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    <!-- Use landing-style header (local to FAQ page only) -->
    <header class="bg-white shadow-md fixed w-full z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-primary">TokoKita</a>

            <nav class="space-x-6 hidden md:block">
                <a href="{{ route('products.index') }}" class="hover:text-primary">Produk</a>
                <a href="{{ url('/#about') }}" class="hover:text-primary">Tentang</a>
                <a href="{{ url('/#help') }}" class="hover:text-primary">Bantuan</a>
                <a href="{{ route('faq') }}" class="hover:text-primary">FAQ</a>
            </nav>

            @guest
                <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-orange-400">
                    Login
                </a>
            @endguest

            @auth
                <a href="{{ route('profile.edit') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Logout</button>
                </form>
            @endauth
        </div>
    </header>

    <div class="h-20"></div>

    <main class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold mb-6 flex items-center gap-2"><i class="fa-solid fa-circle-question text-blue-600"></i> FAQ - Pertanyaan Umum</h1>

            <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                <div>
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <i class="fa-solid fa-truck text-green-600"></i> Bagaimana pengiriman dilakukan?
                    </h3>
                    <p class="text-gray-700 mt-1">Pengiriman dilakukan melalui kurir resmi dengan estimasi 2–5 hari kerja.</p>
                </div>

                <div>
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-yellow-600"></i> Metode pembayaran apa saja yang tersedia?
                    </h3>
                    <p class="text-gray-700 mt-1">Kami menerima transfer bank, e-wallet, dan pembayaran COD di beberapa wilayah.</p>
                </div>

                <div>
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <i class="fa-solid fa-rotate-left text-red-600"></i> Apakah bisa mengembalikan barang?
                    </h3>
                    <p class="text-gray-700 mt-1">Ya, barang bisa dikembalikan dalam 7 hari jika sesuai dengan syarat &amp; ketentuan.</p>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
