<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pesanan
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <form method="GET" class="mb-4">
            <label class="mr-2 font-semibold">Filter Status:</label>
            <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim"  {{ request('status')=='dikirim'  ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai"  {{ request('status')=='selesai'  ? 'selected' : '' }}>Selesai</option>
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
                    <th class="px-4 py-2 text-left">Diskon</th>
                    <th class="px-4 py-2 text-left">Total Akhir</th>
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
                        <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($order->total,0,',','.') }}</td>
                        <td class="px-4 py-2">
                            @if($order->vouchers->isNotEmpty())
                                {{ $order->vouchers->pluck('code')->join(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if(property_exists($order,'discount'))
                                Rp{{ number_format($order->discount,0,',','.') }}
                            @else
                                Rp0
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if(property_exists($order,'final_amount'))
                                Rp{{ number_format($order->final_amount,0,',','.') }}
                            @else
                                Rp{{ number_format($order->total,0,',','.') }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <ul class="list-disc ml-4">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name ?? 'Produk' }} (x{{ $item->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2">{{ optional($order->created_at)->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-2 text-center">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
