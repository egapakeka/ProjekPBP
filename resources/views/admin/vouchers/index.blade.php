<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Voucher
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <a href="{{ route('admin.vouchers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Voucher</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mt-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Kode</th>
                <th class="px-4 py-2 text-left">Tipe</th>
                <th class="px-4 py-2 text-left">Nilai</th>
                <th class="px-4 py-2 text-left">Periode</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vouchers as $voucher)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $voucher->code }}</td>
                    <td class="px-4 py-2">{{ ucfirst($voucher->discount_type) }}</td>
                    <td class="px-4 py-2">{{ $voucher->discount_value }}</td>
                    <td class="px-4 py-2">{{ $voucher->start_date }} s/d {{ $voucher->end_date }}</td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.vouchers.show', $voucher->id) }}" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Detail</a>
                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus voucher ini?')" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4">Belum ada voucher</td></tr>
            @endforelse
        </tbody>
    </table>


        <div class="mt-4">
            {{ $vouchers->links() }}
        </div>
    </div>
</x-app-layout>
