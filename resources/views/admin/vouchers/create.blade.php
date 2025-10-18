<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Voucher
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        @php($oldType = old('discount_type', 'percent'))

        <form method="POST" action="{{ route('admin.vouchers.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block">Kode Voucher</label>
                <input type="text" name="code" value="{{ old('code') }}" class="border rounded w-full px-3 py-2">
                @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Tipe Diskon</label>
                <select name="discount_type" class="border rounded w-full px-3 py-2" data-discount-type>
                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Persen</option>
                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Nominal</option>
                </select>
                @error('discount_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block" data-discount-label>
                    {{ $oldType === 'percent' ? 'Nilai Diskon (%)' : 'Nilai Diskon (Rp)' }}
                </label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="discount_value"
                    value="{{ old('discount_value') }}"
                    placeholder="{{ $oldType === 'percent' ? 'Contoh: 10' : 'Contoh: 50000' }}"
                    class="border rounded w-full px-3 py-2"
                    data-discount-value
                >
                <p class="mt-1 text-xs text-gray-500" data-discount-help>
                    {{ $oldType === 'percent'
                        ? 'Masukkan angka 1-100. Contoh: 10 berarti diskon 10%.'
                        : 'Masukkan nominal diskon dalam rupiah.'
                    }}
                </p>
                @error('discount_value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Minimal Pembelian</label>
                <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase') }}" class="border rounded w-full px-3 py-2">
            </div>

            <div class="{{ $oldType === 'percent' ? '' : 'hidden' }}" data-max-wrapper>
                <label class="block">Maksimal Diskon (Rp)</label>
                <input type="number" step="0.01" min="0" name="max_discount" value="{{ old('max_discount') }}" class="border rounded w-full px-3 py-2" data-max-input {{ $oldType === 'percent' ? '' : 'disabled' }}>
                <p class="mt-1 text-xs text-gray-500">Opsional. Isi untuk membatasi potongan maksimum saat tipe persentase dipakai.</p>
            </div>

            <div>
                <label class="block">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="border rounded w-full px-3 py-2">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Tanggal Berakhir</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="border rounded w-full px-3 py-2">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Batas Pemakaian Total</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="border rounded w-full px-3 py-2">
            </div>

            <div>
                <label class="block">Batas Pemakaian per User</label>
                <input type="number" name="per_user_limit" value="{{ old('per_user_limit') }}" class="border rounded w-full px-3 py-2">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.vouchers.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeSelect = document.querySelector('[data-discount-type]');
            const valueInput = document.querySelector('[data-discount-value]');
            const label = document.querySelector('[data-discount-label]');
            const help = document.querySelector('[data-discount-help]');
            const maxWrapper = document.querySelector('[data-max-wrapper]');
            const maxInput = document.querySelector('[data-max-input]');

            if (!typeSelect || !valueInput || !label || !help || !maxWrapper || !maxInput) {
                return;
            }

            const syncDiscountFields = () => {
                const type = typeSelect.value;

                if (type === 'percent') {
                    label.textContent = 'Nilai Diskon (%)';
                    help.textContent = 'Masukkan angka 1-100. Contoh: 10 berarti diskon 10%.';
                    valueInput.setAttribute('max', '100');
                    valueInput.setAttribute('min', '0');
                    valueInput.setAttribute('step', '0.01');
                    valueInput.placeholder = 'Contoh: 10';
                    maxWrapper.classList.remove('hidden');
                    maxInput.disabled = false;
                } else {
                    label.textContent = 'Nilai Diskon (Rp)';
                    help.textContent = 'Masukkan nominal diskon dalam rupiah.';
                    valueInput.removeAttribute('max');
                    valueInput.setAttribute('min', '0');
                    valueInput.setAttribute('step', '0.01');
                    valueInput.placeholder = 'Contoh: 50000';
                    maxWrapper.classList.add('hidden');
                    maxInput.value = '';
                    maxInput.disabled = true;
                }
            };

            syncDiscountFields();
            typeSelect.addEventListener('change', syncDiscountFields);
        });
    </script>
</x-app-layout>
