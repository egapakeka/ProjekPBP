<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Atur Pengiriman</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Sesuaikan dengan prefix admin.deliveries --}}
            <a href="{{ route('admin.deliveries.create') }}" class="btn btn-primary mb-3">+ Tambah Pengiriman</a>

            <table class="table-auto w-full bg-white shadow rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Pesanan</th>
                        <th class="px-4 py-2">Kurir</th>
                        <th class="px-4 py-2">No. Resi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveries as $d)
                        <tr class="border-t">
                            <td class="px-4 py-2">#{{ $d->order->id ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $d->kurir }}</td>
                            <td class="px-4 py-2">{{ $d->no_resi ?? '-' }}</td>
                            <td class="px-4 py-2 capitalize {{ $d->status_pengiriman === 'selesai' ? 'text-green-600' : '' }}">
                                {{ $d->status_pengiriman }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.deliveries.edit', $d->id) }}" class="text-blue-500">Edit</a> |
                                <form action="{{ route('admin.deliveries.destroy', $d->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada data pengiriman.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $deliveries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
