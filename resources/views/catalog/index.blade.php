<x-app-layout>
    @php
        $user = auth()->user();
        if ($user) {
            $homeLink = $user->role === 'admin'
                ? route('admin.dashboard')
                : route('dashboard');
        } else {
            $homeLink = url('/');
        }
    @endphp

    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ $homeLink }}" class="text-gray-500 hover:text-gray-700">Beranda</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-700 font-medium">Katalog Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($user && $user->role === 'admin')
                <div class="mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-primary hover:text-orange-500">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Kembali ke Dashboard Admin') }}
                    </a>
                </div>
            @endif

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>
                <p class="mt-2 text-gray-600">Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>

            <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-0">
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               placeholder="Cari produk..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

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

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
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

                <div class="flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
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
    </div>
</x-app-layout>
