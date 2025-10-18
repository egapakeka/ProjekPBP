<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }} #{{ $order->id }}
        </h2>
    </x-slot>

    @php
        $statusStyles = [
            'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-yellow-100 text-yellow-800'],
            'diproses' => ['label' => 'Sedang Diproses', 'class' => 'bg-blue-100 text-blue-800'],
            'dikirim' => ['label' => 'Sedang Dikirim', 'class' => 'bg-indigo-100 text-indigo-800'],
            'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
        ];

        $statusMeta = $statusStyles[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-gray-100 text-gray-800'];
        $subtotal = $order->items->sum(function ($item) {
            return $item->subtotal ?? ($item->price * $item->qty);
        });
        $discount = $order->discount ?? 0;
        $finalAmount = $order->final_amount ?? 0;
        if ($finalAmount <= 0 && $order->total > 0) {
            $finalAmount = $order->total - $discount;
        }
        $finalAmount = max($finalAmount, 0);
    @endphp

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-6 border-b border-gray-100 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ __('Pesanan #') }}{{ $order->id }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('Dibuat pada') }}: {{ optional($order->created_at)->format('d M Y H:i') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <span class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold {{ $statusMeta['class'] }}">
                            <i class="fas fa-truck mr-2"></i>{{ $statusMeta['label'] }}
                        </span>
                    </div>
                </div>

                <div class="px-6 py-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-5">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                                {{ __('Informasi Pengiriman') }}
                            </h4>
                            <dl class="mt-4 space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <dt>{{ __('Total Item') }}</dt>
                                    <dd class="font-semibold text-gray-900">
                                        {{ $order->items->sum('qty') }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>{{ __('Alamat Pengiriman') }}</dt>
                                    <dd class="text-right text-gray-700">
                                        {{ $order->address_text ?? 'Tidak tersedia' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-5">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                                {{ __('Ringkasan Pembayaran') }}
                            </h4>
                            <dl class="mt-4 space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <dt>{{ __('Subtotal') }}</dt>
                                    <dd>Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between text-red-600">
                                    <dt>{{ __('Diskon') }}</dt>
                                    <dd>- Rp {{ number_format($discount, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between text-base font-semibold text-gray-900 border-t border-gray-200 pt-3">
                                    <dt>{{ __('Total Dibayar') }}</dt>
                                    <dd>Rp {{ number_format($finalAmount, 0, ',', '.') }}</dd>
                                </div>
                            </dl>

                            @if ($order->vouchers->isNotEmpty())
                                <div class="mt-4 text-sm text-gray-600">
                                    <h5 class="font-semibold text-gray-700">{{ __('Voucher Digunakan') }}</h5>
                                    <ul class="mt-2 space-y-1">
                                        @foreach ($order->vouchers as $voucher)
                                            <li class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                                                <i class="fas fa-ticket-alt mr-2"></i>{{ $voucher->code }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            {{ __('Detail Produk') }}
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 text-left">{{ __('Produk') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Harga Satuan') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Jumlah') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($order->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 font-medium text-gray-900">
                                                {{ optional($item->product)->name ?? __('Produk tidak tersedia') }}
                                            </td>
                                            <td class="px-4 py-4 text-gray-600">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ $item->qty }}
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-gray-900">
                                                Rp {{ number_format($item->subtotal ?? ($item->price * $item->qty), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <a href="{{ route('orders.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Kembali ke Daftar Pesanan') }}
                </a>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 transition">
                    <i class="fas fa-shopping-bag mr-2"></i>{{ __('Belanja Lagi') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
