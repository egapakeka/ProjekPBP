<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Catalog Produk</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" class="text-primary border-b-2 border-primary px-3 py-2 text-sm font-medium">
                            Produk
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-primary hover:text-orange-600 px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary hover:bg-orange-400 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>
                <p class="mt-2 text-gray-600">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>

            <!-- Filter and Search -->
            <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4">
                    <!-- Search -->
                    <div class="flex-1 min-w-0">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="Cari produk..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="min-w-0">
                        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="px-6 py-2 bg-primary hover:bg-orange-400 text-white rounded-lg font-medium">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    
                    @if($search || $selectedCategory)
                        <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium">
                            <i class="fas fa-times mr-2"></i>Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                            <!-- Product Image -->
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-primary bg-orange-100 rounded-full">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                
                                @if($product->description)
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                @endif
                                
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-2xl font-bold text-primary">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <div class="text-sm text-gray-500">
                                            Stok: {{ $product->stock }}
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="bg-primary hover:bg-orange-400 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-16">
                    <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 mb-4">
                        @if($search || $selectedCategory)
                            Coba ubah kata kunci pencarian atau filter kategori.
                        @else
                            Belum ada produk yang tersedia saat ini.
                        @endif
                    </p>
                    @if($search || $selectedCategory)
                        <a href="{{ route('products.index') }}" class="bg-primary hover:bg-orange-400 text-white px-6 py-3 rounded-lg font-medium">
                            Lihat Semua Produk
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2025 {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>