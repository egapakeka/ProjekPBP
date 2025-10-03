<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Voucher
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <form method="POST" action="{{ route('admin.vouchers.update', $voucher->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Kode Voucher</label>
                <input type="text" name="code" value="{{ old('code', $voucher->code) }}" class="border rounded w-full px-3 py-2">
                @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Tipe Diskon</label>
                <select name="discount_type" class="border rounded w-full px-3 py-2">
                    <option value="percent" {{ $voucher->discount_type == 'percent' ? 'selected' : '' }}>Persen</option>
                    <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Nominal</option>
                </select>
                @error('discount_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Nilai Diskon</label>
                <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $voucher->discount_value) }}" class="border rounded w-full px-3 py-2">
                @error('discount_value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Minimal Pembelian</label>
                <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase', $voucher->min_purchase) }}" class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block">Maksimal Diskon</label>
                <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount', $voucher->max_discount) }}" class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date', $voucher->start_date) }}" class="border rounded w-full px-3 py-2">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Tanggal Berakhir</label>
                <input type="date" name="end_date" value="{{ old('end_date', $voucher->end_date) }}" class="border rounded w-full px-3 py-2">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Batas Pemakaian Total</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}" class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block">Batas Pemakaian per User</label>
                <input type="number" name="per_user_limit" value="{{ old('per_user_limit', $voucher->per_user_limit) }}" class="border rounded w-full px-3 py-2">
            </div>

            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.vouchers.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
