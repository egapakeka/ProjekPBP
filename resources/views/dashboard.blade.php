<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard - Selamat Datang, {{ Auth::user()->name }}!
            </h2>
            <a href="{{ route('products.index') }}" class="bg-primary hover:bg-orange-400 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <i class="fas fa-store mr-2"></i>Lihat Semua Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-primary">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-700">Total Produk</h3>
                                <p class="text-3xl font-bold text-primary">{{ $totalProducts }}</p>
                                <p class="text-sm text-gray-500">Produk aktif</p>
                            </div>
                            <div class="p-3 bg-orange-100 rounded-full">
                                <i class="fas fa-box text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-primary">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-700">Total Kategori</h3>
                                <p class="text-3xl font-bold text-primary">{{ $totalCategories }}</p>
                                <p class="text-sm text-gray-500">Kategori dengan produk</p>
                            </div>
                            <div class="p-3 bg-orange-100 rounded-full">
                                <i class="fas fa-tags text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-700">Stok Terbatas</h3>
                                <p class="text-3xl font-bold text-red-600">{{ $lowStockProducts }}</p>
                                <p class="text-sm text-gray-500">Produk ≤ 10 unit</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products by Category -->
            @foreach($categoriesWithProducts as $category)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Category Header -->
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-layer-group text-primary mr-3"></i>
                                    {{ $category->name }}
                                </h3>
                                <p class="text-gray-600 mt-1">
                                    {{ $category->products->count() }} produk tersedia
                                    @if($category->products->count() >= 4)
                                        <span class="text-sm">(menampilkan 4 terbaru)</span>
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                               class="text-primary hover:text-orange-600 font-medium">
                                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <!-- Products Grid -->
                        @if($category->products->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                                @foreach($category->products as $product)
                                    <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition duration-300 cursor-pointer"
                                         onclick="window.location='{{ route('products.show', $product) }}'">
                                        <!-- Product Image -->
                                        <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                            @if($product->image)
                                                <img src="{{ asset('storage/'.$product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-full h-48 object-cover">
                                            @else
                                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400 text-3xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="p-4">
                                            <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-sm">
                                                {{ $product->name }}
                                            </h4>
                                            
                                            @if($product->description)
                                                <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                                                    {{ Str::limit($product->description, 80) }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-lg font-bold text-primary">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <div class="text-xs text-gray-500">
                                                    Stok: {{ $product->stock }}
                                                </div>
                                                
                                                @if($product->stock > 10)
                                                    <span class="text-xs px-2 py-1 bg-orange-100 text-primary rounded-full">
                                                        Tersedia
                                                    </span>
                                                @elseif($product->stock > 0)
                                                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                                        Terbatas
                                                    </span>
                                                @else
                                                    <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full">
                                                        Habis
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-4"></i>
                                <p>Belum ada produk di kategori ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($categoriesWithProducts->count() == 0)
                <!-- No Products Available -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <i class="fas fa-store text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500 mb-6">Saat ini belum ada produk yang tersedia di toko.</p>
                        @if(auth()->user()->email === 'admin@admin.com' || auth()->user()->role === 'admin')
                            <a href="{{ route('admin.products.create') }}" 
                               class="bg-primary hover:bg-orange-400 text-white px-6 py-3 rounded-lg font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Produk Pertama
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
