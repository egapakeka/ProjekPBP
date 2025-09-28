<x-app-layout>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Produk</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.products.edit', $product) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Produk</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">ID Produk</label>
                            <p class="text-gray-900 font-semibold">{{ $product->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nama Produk</label>
                            <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Kategori</label>
                            <p class="text-gray-900">{{ $product->category->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Harga</label>
                            <p class="text-gray-900 text-xl font-bold text-green-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Stok & Status</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Stok Tersedia</label>
                            <p class="text-gray-900 text-2xl font-bold">{{ $product->stock }} unit</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Status Produk</label>
                            <div class="mt-1">
                                @if($product->is_active)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-2"></i>Nonaktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Status Stok</label>
                            <div class="mt-1">
                                @if($product->stock > 10)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Stok Aman
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Stok Terbatas
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <p>Dibuat: {{ $product->created_at ? $product->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                    <p>Diupdate: {{ $product->updated_at ? $product->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
                
                <div class="space-x-2">
                    <form action="{{ route('admin.products.destroy', $product) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>