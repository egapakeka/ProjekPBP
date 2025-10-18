<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
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
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ __('Riwayat & Status Pesanan') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Pantau status pesananmu dan lihat detail transaksi terbaru di sini.') }}
                    </p>
                </div>

                <div class="px-6 py-6">
                    @if ($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 text-left">{{ __('No. Pesanan') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Tanggal') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Jumlah Item') }}</th>
                                        <th class="px-4 py-3 text-left">{{ __('Total Bayar') }}</th>
                                        <th class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($orders as $order)
                                        @php
                                            $style = $statusStyles[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-gray-100 text-gray-800'];
                                            $itemsCount = $order->items->sum('qty');
                                            $finalAmount = $order->final_amount ?? 0;
                                            if ($finalAmount <= 0 && $order->total > 0) {
                                                $finalAmount = $order->total;
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 font-semibold text-gray-900">
                                                #{{ $order->id }}
                                            </td>
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ optional($order->created_at)->format('d M Y H:i') ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $style['class'] }}">
                                                    {{ $style['label'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ $itemsCount }}
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-gray-900">
                                                Rp {{ number_format($finalAmount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex flex-col items-end gap-2">
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                       class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                                                        {{ __('Lihat Detail') }}
                                                    </a>
                                                    @if ($order->status === 'dibatalkan')
                                                        <span class="text-xs font-semibold text-red-500">
                                                            {{ __('Pesanan dibatalkan oleh admin.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                <i class="fas fa-box-open text-2xl"></i>
                            </div>
                            <h4 class="mt-6 text-lg font-semibold text-gray-900">
                                {{ __('Belum ada pesanan') }}
                            </h4>
                            <p class="mt-2 text-sm text-gray-500">
                                {{ __('Yuk mulai belanja dan buat pesanan pertamamu sekarang!') }}
                            </p>
                            <a href="{{ route('products.index') }}"
                               class="mt-6 inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 transition">
                                <i class="fas fa-shopping-bag mr-2"></i>
                                {{ __('Lihat Produk') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
