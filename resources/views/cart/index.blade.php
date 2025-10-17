<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Keranjang Belanja') }}
            </h2>

            <a href="{{ route('products.index') }}" class="text-sm font-medium text-primary hover:text-orange-500">
                {{ __('Lanjut Belanja') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-6">
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($cart->items->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                            <p>{{ __('Keranjang kamu masih kosong.') }}</p>
                            <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-orange-500">
                                {{ __('Mulai Belanja') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Produk') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Harga') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Jumlah') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">{{ __('Subtotal') }}</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cart->items as $item)
                                        @php($price = $item->product->price ?? 0)
                                        @php($maxQty = $item->product->stock ?? 0)
                                        <tr data-cart-item-row data-item-id="{{ $item->id }}">
                                            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                                {{ $item->product->name ?? __('Produk tidak tersedia') }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                                @if ($item->product)
                                                    Rp {{ number_format($price, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                                <form action="{{ route('cart.items.update', $item) }}" method="POST"
                                                      class="cart-item-form flex items-center space-x-2"
                                                      data-update-url="{{ route('cart.items.update', $item) }}"
                                                      data-subtotal-target="subtotal-{{ $item->id }}"
                                                      data-price="{{ $price }}"
                                                      data-max="{{ $maxQty }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="qty" value="{{ $item->qty }}" min="1"
                                                           data-cart-qty-input
                                                           @if($maxQty) max="{{ $maxQty }}" @endif
                                                           @if(!$item->product) disabled @endif
                                                           class="w-20 rounded-md border-gray-300 text-sm shadow-sm focus:border-primary focus:ring-primary" />
                                                    <span class="text-xs text-gray-400 opacity-0 transition" data-sync-indicator>{{ __('Menyimpan...') }}</span>
                                                    <button type="submit" class="sr-only">{{ __('Update') }}</button>
                                                </form>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-900" id="subtotal-{{ $item->id }}" data-cart-subtotal>
                                                @if ($item->product)
                                                    Rp {{ number_format($price * $item->qty, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm">
                                                <form action="{{ route('cart.items.destroy', $item) }}" method="POST" onsubmit="return confirm('{{ __('Hapus produk ini dari keranjang?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                {{ __('Total produk:') }} <span data-cart-total-count>{{ $cart->items->sum('qty') }}</span>
                            </div>
                            <div class="text-xl font-bold text-gray-900">
                                {{ __('Total:') }} <span data-cart-total-amount>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($cart->items->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const forms = document.querySelectorAll('.cart-item-form');
                if (!forms.length) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const currencyFormatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
                const totalCountEl = document.querySelector('[data-cart-total-count]');
                const totalAmountEl = document.querySelector('[data-cart-total-amount]');
                const cartBadges = document.querySelectorAll('[data-cart-count-badge]');

                const updateBadge = (count) => {
                    cartBadges.forEach((badge) => {
                        const valueEl = badge.querySelector('[data-cart-count-value]');
                        if (count > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                        if (valueEl) {
                            valueEl.textContent = count;
                        }
                    });
                };

                const recalcTotals = () => {
                    let runningTotal = 0;
                    let runningCount = 0;

                    forms.forEach((form) => {
                    const price = parseFloat(form.dataset.price || '0');
                    const input = form.querySelector('[data-cart-qty-input]');
                    const subtotalTarget = document.getElementById(form.dataset.subtotalTarget);
                    if (!input || input.disabled) {
                        return;
                    }
                    let qty = parseInt(input.value, 10);
                    const max = parseInt(form.dataset.max || '0', 10);

                    if (!Number.isFinite(qty) || qty < 1) {
                        qty = 1;
                        input.value = qty;
                    }

                    if (Number.isFinite(max) && max > 0 && qty > max) {
                        qty = max;
                        input.value = max;
                    }

                    const subtotal = price * qty;
                    runningTotal += subtotal;
                    runningCount += qty;

                        if (subtotalTarget) {
                            subtotalTarget.textContent = currencyFormatter.format(subtotal);
                        }
                    });

                    if (totalCountEl) {
                        totalCountEl.textContent = runningCount;
                    }

                    if (totalAmountEl) {
                        totalAmountEl.textContent = currencyFormatter.format(runningTotal);
                    }

                    updateBadge(runningCount);
                };

                const sendUpdate = (form, qty, indicator, input) => {
                    if (!csrfToken) return;

                    indicator?.classList.remove('text-red-600');
                    if (indicator) {
                        indicator.textContent = '{{ __('Menyimpan...') }}';
                        indicator.classList.remove('opacity-0');
                    }

                    const formData = new FormData();
                    formData.append('_method', 'PATCH');
                    formData.append('qty', qty);
                    formData.append('_token', csrfToken);

                    fetch(form.dataset.updateUrl || form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData,
                    })
                        .then((response) => {
                            if (response.status === 422) {
                                return response.json().then((data) => {
                                    throw { type: 'validation', data };
                                });
                            }

                            if (!response.ok) {
                                throw new Error('Request failed');
                            }

                            return response.json().catch(() => null);
                        })
                        .then((data) => {
                            if (data) {
                                if (data.subtotal_formatted) {
                                    const subtotalTarget = document.getElementById(form.dataset.subtotalTarget);
                                    if (subtotalTarget) {
                                        subtotalTarget.textContent = data.subtotal_formatted;
                                    }
                                }

                                if (totalAmountEl && data.total_formatted) {
                                    totalAmountEl.textContent = data.total_formatted;
                                }

                                if (totalCountEl && typeof data.items_count !== 'undefined') {
                                    totalCountEl.textContent = data.items_count;
                                }

                                if (typeof data.items_count !== 'undefined') {
                                    updateBadge(data.items_count);
                                }
                            }

                            if (indicator) {
                                indicator.textContent = '{{ __('Tersimpan') }}';
                                setTimeout(() => indicator.classList.add('opacity-0'), 1200);
                            }
                        })
                        .catch((error) => {
                            if (error?.type === 'validation') {
                                const message = error.data?.errors?.qty?.[0] || error.data?.message || '{{ __('Gagal menyimpan') }}';
                                if (indicator) {
                                    indicator.textContent = message;
                                    indicator.classList.remove('opacity-0');
                                    indicator.classList.add('text-red-600');
                                }

                                if (typeof error.data?.max !== 'undefined' && input) {
                                    const maxVal = parseInt(error.data.max, 10);
                                    if (Number.isFinite(maxVal) && maxVal > 0) {
                                        input.value = maxVal;
                                    }
                                    recalcTotals();
                                }

                                setTimeout(() => {
                                    indicator?.classList.add('opacity-0');
                                }, 1800);
                                return;
                            }

                            if (indicator) {
                                indicator.textContent = '{{ __('Gagal menyimpan') }}';
                                indicator.classList.add('text-red-600');
                                setTimeout(() => {
                                    indicator.classList.remove('text-red-600');
                                    indicator.classList.add('opacity-0');
                                }, 1500);
                            }
                        });
                };

                forms.forEach((form) => {
                    const input = form.querySelector('[data-cart-qty-input]');
                    const indicator = form.querySelector('[data-sync-indicator]');
                    let debounceTimer;

                    if (!input || input.disabled) {
                        return;
                    }

                    const max = parseInt(form.dataset.max || '0', 10);
                    const handleChange = () => {
                        clearTimeout(debounceTimer);
                        if (Number.isFinite(max) && max > 0 && Number(input.value) > max) {
                            input.value = max;
                        }
                        recalcTotals();

                        debounceTimer = setTimeout(() => {
                            const qty = parseInt(input.value, 10) || 1;
                            sendUpdate(form, qty, indicator, input);
                        }, 500);
                    };

                    input.addEventListener('input', handleChange);
                    input.addEventListener('change', handleChange);
                    input.addEventListener('blur', () => {
                        clearTimeout(debounceTimer);
                        if (Number.isFinite(max) && max > 0 && Number(input.value) > max) {
                            input.value = max;
                        }
                        recalcTotals();
                        const qty = parseInt(input.value, 10) || 1;
                        sendUpdate(form, qty, indicator, input);
                    });
                });

                recalcTotals();
            });
        </script>
    @endif
</x-app-layout>
