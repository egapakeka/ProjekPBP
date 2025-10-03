<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Voucher: {{ $voucher->code }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Voucher</h3>
            <p><strong>Kode:</strong> {{ $voucher->code }}</p>
            <p><strong>Tipe Diskon:</strong> {{ ucfirst($voucher->discount_type) }}</p>
            <p><strong>Nilai Diskon:</strong> {{ $voucher->discount_value }}</p>
            <p><strong>Minimal Pembelian:</strong> {{ $voucher->min_purchase ?? '-' }}</p>
            <p><strong>Maksimal Diskon:</strong> {{ $voucher->max_discount ?? '-' }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $voucher->start_date }}</p>
            <p><strong>Tanggal Berakhir:</strong> {{ $voucher->end_date }}</p>
            <p><strong>Batas Pemakaian Total:</strong> {{ $voucher->usage_limit ?? '-' }}</p>
            <p><strong>Batas Pemakaian per User:</strong> {{ $voucher->per_user_limit ?? '-' }}</p>
            <p><strong>Dibuat pada:</strong> {{ $voucher->created_at }}</p>
        </div>

        <div class="mt-6 space-x-2">
            <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                Kembali
            </a>
            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Edit
            </a>
            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus voucher ini?')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
