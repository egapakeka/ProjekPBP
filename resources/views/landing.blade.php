<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKita - Landing Page</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mainLogo/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/mainLogo/logo.png') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navigasi --}}
    @include('layouts.navigation')

    {{-- Hero Section --}}
    <section class="pt-28 pb-20 bg-primary text-white text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Belanja Lebih Mudah di TokoKita</h1>
            <p class="text-lg md:text-xl mb-8">Dapatkan produk terbaik dengan harga terjangkau, hanya di TokoKita.</p>
            <a href="#products" class="bg-white text-primary font-semibold px-6 py-3 rounded-lg hover:bg-gray-200">
                Lihat Produk
            </a>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section id="products" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-6">Produk Unggulan</h2>

            @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-48 w-full object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $product->description }}</p>
                                <p class="text-orange-500 font-bold mt-2">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="inline-block mt-3 bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 mt-8">Belum ada produk yang tersedia saat ini.</p>
            @endif
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="about" class="py-20 bg-gray-100 scroll-mt-28">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Tentang TokoKita</h2>
            <p class="max-w-2xl mx-auto text-gray-600">
                TokoKita adalah platform e-commerce yang menyediakan berbagai kebutuhan Anda.
                Untuk cerita lengkap kami, kunjungi halaman 
                <a href="{{ route('about') }}" class="text-primary underline">Tentang Kami</a>.
            </p>
        </div>
    </section>

    {{-- Hubungi Kami --}}
    <section id="help" class="py-20 container mx-auto px-6 scroll-mt-28">
        <h2 class="text-3xl font-bold text-center mb-6">Hubungi Kami</h2>
        <form class="max-w-xl mx-auto space-y-6">
            <input type="text" placeholder="Nama" class="w-full p-3 border rounded-lg">
            <input type="email" placeholder="Email" class="w-full p-3 border rounded-lg">
            <textarea placeholder="Pesan" class="w-full p-3 border rounded-lg"></textarea>
            <a href="{{ route('help') }}" class="block w-full text-center bg-primary text-white py-3 rounded-lg hover:bg-indigo-700">
                Kirim via Halaman Bantuan
            </a>
        </form>
    </section>

    {{-- Smooth Scroll Style --}}
    <style>
        html { scroll-behavior: smooth; }
        .scroll-mt-28 { scroll-margin-top: 7rem; }
    </style>

    {{-- Footer --}}
    @include('layouts.footer')

</body>
</html>
