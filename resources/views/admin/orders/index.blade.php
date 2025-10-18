<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pesanan
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        @php
            $statusLabels = [
                'pending' => ['label' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-800'],
                'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
                'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-indigo-100 text-indigo-800'],
                'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
            ];
        @endphp

        <form method="GET" class="mb-4">
            <label class="mr-2 font-semibold">Filter Status:</label>
            <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim"  {{ request('status')=='dikirim'  ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai"  {{ request('status')=='selesai'  ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan"  {{ request('status')=='dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </form>

        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Total</th>
                    <th class="px-4 py-2 text-left">Voucher</th>
                    <th class="px-4 py-2 text-left">Items</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                        @php
                            $statusMeta = $statusLabels[$order->status] ?? ['label' => ucfirst($order->status ?? '—'), 'class' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <td class="px-4 py-2 capitalize">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['class'] }}">
                                {{ $statusMeta['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div>Rp{{ number_format($order->final_amount ?? $order->total,0,',','.') }}</div>
                            @if(($order->discount ?? 0) > 0)
                                <div class="text-xs text-gray-500">{{ __('Diskon:') }} Rp{{ number_format($order->discount,0,',','.') }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            @forelse($order->voucherUsages as $usage)
                                <span class="inline-flex items-center rounded-full bg-primary/10 px-2 py-1 text-xs font-semibold text-primary">
                                    {{ $usage->voucher->code ?? '-' }}
                                </span>
                            @empty
                                <span class="text-gray-400">-</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-2">
                            <ul class="list-disc ml-4">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name ?? 'Produk' }} (x{{ $item->qty }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}</td>

                        <td class="px-4 py-2">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                  method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border rounded px-2 py-1">
                                    <option value="diproses" {{ $order->status=='diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim"  {{ $order->status=='dikirim'  ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai"  {{ $order->status=='selesai'  ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan"  {{ $order->status=='dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>
                        </td>
                        {{-- ==== END FORM ==== --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
