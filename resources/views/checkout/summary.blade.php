@php($user = auth()->user())

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <a href="{{ route('cart.index') }}" class="text-sm font-medium text-primary hover:text-orange-500">
                {{ __('Kembali ke Keranjang') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Ringkasan Pesanan') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Periksa produk yang akan kamu checkout sebelum melanjutkan.') }}</p>
                </div>
                <div class="px-6 py-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider text-gray-500">{{ __('Produk') }}</th>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider text-gray-500">{{ __('Harga') }}</th>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider text-gray-500">{{ __('Jumlah') }}</th>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider text-gray-500">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $item->product->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $item->qty }}</td>
                                        <td class="px-4 py-3 font-semibold text-gray-900">Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 rounded-lg bg-gray-50 px-4 py-4 text-sm text-gray-600 space-y-2">
                        <div class="flex justify-between">
                            <span>{{ __('Total Produk') }}</span>
                            <span class="font-semibold text-gray-900">{{ $totalQty }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ __('Subtotal') }}</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-red-600" data-voucher-discount-wrapper>
                            <span>{{ __('Diskon Voucher') }}</span>
                            <span data-voucher-discount>Rp 0</span>
                        </div>
                        <div class="mt-2 flex justify-between text-base font-semibold text-gray-900">
                            <span>{{ __('Total Pembayaran') }}</span>
                            <span data-voucher-final>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Alamat & Voucher') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Silakan lengkapi alamat dan (opsional) pilih voucher untuk mendapatkan diskon.') }}</p>
                </div>
                <div class="px-6 py-6">
                    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="selected_items" value="{{ $selectedIds }}">
                        <input type="hidden" name="total" value="{{ $total }}">

                        @if ($vouchers->isNotEmpty())
                            <div>
                                <label for="voucher_id" class="block text-sm font-medium text-gray-700">{{ __('Pilih Voucher (Opsional)') }}</label>
                                <select id="voucher_id" name="voucher_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        data-voucher-select data-original-total="{{ $total }}">
                                    @php($selectedVoucher = old('voucher_id'))
                                    <option value="">{{ __('Tidak pakai voucher') }}</option>
                                    @foreach ($vouchers as $voucher)
                                        @php($discountAmount = $voucher->calculateDiscount($total))
                                        <option value="{{ $voucher->id }}"
                                                data-type="{{ $voucher->discount_type }}"
                                                data-value="{{ $voucher->discount_value }}"
                                                data-max="{{ $voucher->max_discount ?? '' }}"
                                                data-code="{{ $voucher->code }}"
                                                data-discount="{{ $discountAmount }}"
                                                {{ (string)$selectedVoucher === (string)$voucher->id ? 'selected' : '' }}>
                                            {{ $voucher->code }} —
                                            @if($voucher->discount_type === 'percent')
                                                {{ $voucher->discount_value }}% (maks {{ $voucher->max_discount ? 'Rp '.number_format($voucher->max_discount,0,',','.') : 'tanpa batas' }})
                                            @else
                                                Diskon Rp {{ number_format($voucher->discount_value,0,',','.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Alamat Lengkap') }}</label>
                            <textarea id="address" name="address" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                {{ __('Kembali ke Keranjang') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <i class="fas fa-check mr-2"></i>
                                {{ __('Konfirmasi Checkout') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.querySelector('[data-voucher-select]');
            const discountEl = document.querySelector('[data-voucher-discount]');
            const finalEl = document.querySelector('[data-voucher-final]');
            const discountWrapper = document.querySelector('[data-voucher-discount-wrapper]');
            const originalTotal = select ? parseFloat(select.dataset.originalTotal || '0') : 0;

            if (!select || !discountEl || !finalEl) {
                return;
            }

            const formatCurrency = (amount) =>
                new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);

            const updateTotals = () => {
                const option = select.selectedOptions[0];
                const discount = option && option.dataset.discount ? parseFloat(option.dataset.discount) : 0;
                const finalTotal = Math.max(originalTotal - discount, 0);

                if (discount > 0) {
                    discountWrapper.classList.remove('text-gray-400');
                } else {
                    discountWrapper.classList.add('text-gray-400');
                }

                discountEl.textContent = formatCurrency(discount);
                finalEl.textContent = formatCurrency(finalTotal);
            };

        updateTotals();
        select.addEventListener('change', updateTotals);
        });
    </script>
</x-app-layout>
