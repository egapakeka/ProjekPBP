<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $product->name }} - {{ config('app.name', 'Laravel') }}</title>
    
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
                        <a href="{{ route('products.index') }}" class="text-primary hover:text-orange-600 px-3 py-2 text-sm font-medium">
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
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
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

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Produk</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-600">{{ $product->category->name }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-700 font-medium">{{ Str::limit($product->name, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Product Detail -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Product Image -->
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover rounded-lg">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-6xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Info -->
                    <div>
                        <!-- Category Badge -->
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-sm font-semibold text-primary bg-orange-100 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <!-- Product Name -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        <!-- Price -->
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <span class="text-gray-600 mr-2">Stok:</span>
                                @if($product->stock > 10)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Tersedia ({{ $product->stock }} unit)
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Terbatas ({{ $product->stock }} unit)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Description -->
                        @if($product->description)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            @auth
                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('cart.store') }}" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <div>
                                            <label for="qty" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                            <div class="mt-1 flex items-center space-x-3">
                                                <input id="qty" name="qty" type="number" min="1" max="{{ $product->stock }}" value="{{ old('qty', 1) }}"
                                                       class="w-24 rounded-lg border border-gray-300 px-3 py-2 focus:border-primary focus:ring-primary">
                                                <span class="text-sm text-gray-500">dari {{ $product->stock }} tersedia</span>
                                            </div>
                                            @error('qty')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit" class="w-full bg-primary hover:bg-orange-400 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                            <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                        </button>
                                    </form>

                                    <button type="button" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                        <i class="fas fa-bolt mr-2"></i>Beli Sekarang
                                    </button>
                                @else
                                    <button disabled class="w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-times mr-2"></i>Stok Habis
                                    </button>
                                @endif
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 text-center mb-4">
                                        <i class="fas fa-info-circle mr-2"></i>Silahkan login untuk membeli produk
                                    </p>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('login') }}" class="flex-1 bg-primary hover:bg-orange-400 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                                            Login
                                        </a>
                                        <a href="{{ route('register') }}" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                                            Register
                                        </a>
                                    </div>
                                </div>
                            @endauth
                            
                            <a href="{{ route('products.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center block transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition duration-300">
                                <!-- Product Image -->
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/'.$relatedProduct->image) }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-primary">
                                            Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                        </span>
                                        
                                        <a href="{{ route('products.show', $relatedProduct) }}" 
                                           class="bg-primary hover:bg-orange-400 text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
