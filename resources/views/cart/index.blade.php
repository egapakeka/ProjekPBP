<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Keranjang Belanja') }}
            </h2>

            <a href="{{ route('products.index') }}" class="text-sm font-medium text-primary hover:text-orange-500">
                {{ __('Lanjut Belanja') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-6">
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($cart->items->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                            <p>{{ __('Keranjang kamu masih kosong.') }}</p>
                            <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-orange-500">
                                {{ __('Mulai Belanja') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Produk') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Harga') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Jumlah') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Subtotal') }}</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                                {{ $item->product->name ?? __('Produk tidak tersedia') }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                                @if ($item->product)
                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                                <form action="{{ route('cart.items.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="qty" value="{{ $item->qty }}" min="1"
                                                           class="w-20 rounded-md border-gray-300 text-sm shadow-sm focus:border-primary focus:ring-primary" />
                                                    <button type="submit" class="text-sm font-medium text-primary hover:text-orange-500">
                                                        {{ __('Update') }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-900">
                                                @if ($item->product)
                                                    Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm">
                                                <form action="{{ route('cart.items.destroy', $item) }}" method="POST" onsubmit="return confirm('{{ __('Hapus produk ini dari keranjang?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                {{ __('Total produk:') }} {{ $cart->items->sum('qty') }}
                            </div>
                            <div class="text-xl font-bold text-gray-900">
                                {{ __('Total:') }} Rp {{ number_format($total, 0, ',', '.') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
