<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                &larr; Kembali ke daftar
            </a>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Tanggal Checkout</p>
                    <p>{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Status</p>
                    <p class="capitalize">{{ $order->status }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Total Awal</p>
                    <p>Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Diskon</p>
                    <p>Rp{{ number_format($order->discount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Total Akhir</p>
                    <p>Rp{{ number_format($order->final_amount ?? $order->total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">Informasi Pengguna</h3>
            <div class="text-sm text-gray-700 space-y-1">
                <p><span class="text-gray-500">Nama:</span> {{ $order->user->name ?? '-' }}</p>
                <p><span class="text-gray-500">Email:</span> {{ $order->user->email ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">Alamat Pengiriman</h3>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $order->address_text }}</p>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Voucher Digunakan</h3>
            </div>
            <div class="text-sm text-gray-700 space-y-2">
                @forelse($order->vouchers as $voucher)
                    <div class="flex items-center justify-between border border-gray-200 rounded px-3 py-2">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $voucher->code }}</p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst($voucher->discount_type) }} -
                                {{ $voucher->discount_type === 'percent'
                                    ? $voucher->discount_value . '%'
                                    : 'Rp'.number_format($voucher->discount_value, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-right text-xs text-gray-500">
                            Digunakan pada:
                            {{ optional($voucher->pivot->created_at)->format('d-m-Y H:i') ?? '-' }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada voucher yang digunakan.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">Produk</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-500 uppercase tracking-wide text-xs">Produk</th>
                            <th class="px-4 py-2 text-left text-gray-500 uppercase tracking-wide text-xs">Harga</th>
                            <th class="px-4 py-2 text-left text-gray-500 uppercase tracking-wide text-xs">Jumlah</th>
                            <th class="px-4 py-2 text-left text-gray-500 uppercase tracking-wide text-xs">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->product->name ?? 'Produk' }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $item->qty }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
