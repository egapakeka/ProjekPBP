<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKita - Landing Page</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar khusus landing --}}
    <header class="bg-white shadow-md fixed w-full z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-primary">TokoKita</a>

            <nav class="space-x-6 hidden md:block">
                <a href="{{ route('products.index') }}" class="hover:text-primary">Produk</a>
                <a href="{{ route('about') }}" class="hover:text-primary">Tentang</a>
                <a href="{{ route('help') }}" class="hover:text-primary">Bantuan</a>
                <a href="{{ route('faq') }}" class="hover:text-primary">FAQ</a>
            </nav>

            {{-- Guest: Login --}}
            @guest
                <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-orange-400">
                    Login
                </a>
            @endguest

            {{-- Authenticated: Profil / Logout --}}
            @auth
                <a href="{{ route('profile.edit') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200">
                    Profil Saya
                </a>

                {{-- Logout Form --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </header>

    {{-- Hero --}}
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
    <section id="products" class="py-20 container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Produk Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ([
                ['name' => 'Sepatu Sneakers', 'price' => 'Rp 350.000', 'img' => asset('images/sepatu.jpeg')],
                ['name' => 'Tas Ransel',     'price' => 'Rp 250.000', 'img' => asset('images/tas.jpeg')],
                ['name' => 'Jam Tangan',     'price' => 'Rp 500.000', 'img' => asset('images/jam.jpeg')],
            ] as $product)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}" class="w-full h-56 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product['name'] }}</h3>
                        <p class="text-black font-bold">{{ $product['price'] }}</p>
                        <a href="{{ route('products.index') }}" class="block mt-4 bg-primary text-white text-center py-2 rounded-lg hover:bg-indigo-700">
                            Beli Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Tentang (ringkas, halaman lengkap ada di /about) --}}
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Tentang TokoKita</h2>
            <p class="max-w-2xl mx-auto text-gray-600">
                TokoKita adalah platform e-commerce yang menyediakan berbagai kebutuhan Anda.
                Untuk cerita lengkap kami, kunjungi halaman <a href="{{ route('about') }}" class="text-primary underline">Tentang Kami</a>.
            </p>
        </div>
    </section>

    {{-- Kontak ringkas, halaman lengkap di /help --}}
    <section class="py-20 container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Hubungi Kami</h2>
        <form class="max-w-xl mx-auto space-y-6">
            <input type="text" placeholder="Nama" class="w-full p-3 border rounded-lg">
            <input type="email" placeholder="Email" class="w-full p-3 border rounded-lg">
            <textarea placeholder="Pesan" class="w-full p-3 border rounded-lg"></textarea>
            <a href="{{ route('help') }}" class="block w-full text-center bg-primary text-white py-3 rounded-lg hover:bg-indigo-700">
                Kirim via Halaman Bantuan
            </a>
        </form>
    </section>

    {{-- Footer default (FAQ / Bantuan / Tentang) --}}
    @include('layouts.footer')

</body>
</html>
