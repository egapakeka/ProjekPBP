<x-app-layout>
    @php
        $user = auth()->user();
        if ($user) {
            $dashboardUrl = $user->role === 'admin'
                ? route('admin.dashboard')
                : route('dashboard');
        } else {
            $dashboardUrl = url('/');
        }
    @endphp

    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ $dashboardUrl }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
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

                    <div>
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-sm font-semibold text-primary bg-orange-100 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $product->name }}
                        </h1>

                        <div class="mb-6">
                            <span class="text-4xl font-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

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

                        @if($product->description)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

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

            @if($relatedProducts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition duration-300">
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
    </div>
</x-app-layout>
