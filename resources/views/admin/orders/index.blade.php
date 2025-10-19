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

        @if(session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-2 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div data-order-status-toast class="mb-4 hidden rounded border px-4 py-2 text-sm"></div>

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
                    <tr data-order-row="{{ $order->id }}">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                        @php
                            $statusMeta = $statusLabels[$order->status] ?? ['label' => ucfirst($order->status ?? '—'), 'class' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <td class="px-4 py-2 capitalize">
                            <span
                                data-status-badge
                                data-base-class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['class'] }}">
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
                            <form
                                action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                method="POST"
                                class="flex items-center gap-2"
                                data-order-status-form>
                                @csrf
                                @method('PUT')
                                <select name="status" class="border rounded px-2 py-1">
                                    <option value="diproses" {{ $order->status=='diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim"  {{ $order->status=='dikirim'  ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai"  {{ $order->status=='selesai'  ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan"  {{ $order->status=='dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
                                        data-status-submit>
                                    Simpan
                                </button>
                                <span class="text-xs text-gray-500" data-status-feedback></span>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('[data-order-status-form]');
            if (!forms.length) {
                return;
            }

            const statusMap = {
                pending: { label: 'Pending', class: 'bg-yellow-100 text-yellow-800' },
                diproses: { label: 'Diproses', class: 'bg-blue-100 text-blue-800' },
                dikirim: { label: 'Dikirim', class: 'bg-indigo-100 text-indigo-800' },
                selesai: { label: 'Selesai', class: 'bg-green-100 text-green-800' },
                dibatalkan: { label: 'Dibatalkan', class: 'bg-red-100 text-red-800' },
                default: { label: 'Status diperbarui', class: 'bg-gray-100 text-gray-800' },
            };

            const toast = document.querySelector('[data-order-status-toast]');
            let toastTimer;

            const showToast = (message, type = 'success') => {
                if (!toast || !message) {
                    return;
                }

                const successClasses = ['border-green-200', 'bg-green-50', 'text-green-700'];
                const errorClasses = ['border-red-200', 'bg-red-50', 'text-red-700'];

                toast.textContent = message;
                toast.classList.remove('hidden', ...successClasses, ...errorClasses);
                toast.classList.add(...(type === 'success' ? successClasses : errorClasses));

                clearTimeout(toastTimer);
                toastTimer = setTimeout(() => {
                    toast.classList.add('hidden');
                }, 3200);
            };

            forms.forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    const submitButton = form.querySelector('[data-status-submit]');
                    const feedback = form.querySelector('[data-status-feedback]');
                    const badge = form.closest('tr')?.querySelector('[data-status-badge]');
                    const select = form.querySelector('select[name="status"]');

                    if (!select) {
                        return;
                    }

                    const originalText = submitButton?.textContent;
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Menyimpan...';
                    }

                    if (feedback) {
                        feedback.textContent = 'Menyimpan perubahan...';
                        feedback.classList.remove('text-red-600');
                        feedback.classList.add('text-gray-500');
                    }

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    })
                        .then(async (response) => {
                            if (!response.ok) {
                                const data = await response.json().catch(() => ({}));
                                throw { status: response.status, data };
                            }
                            return response.json();
                        })
                        .then((data) => {
                            const status = data.status || select.value;
                            const meta = statusMap[status] || statusMap.default;

                            if (badge) {
                                const baseClass = badge.dataset.baseClass || badge.className;
                                badge.className = `${baseClass} ${data.badge_class || meta.class}`.trim();
                                badge.textContent = data.label || meta.label;
                            }

                            if (feedback) {
                                feedback.textContent = data.message || 'Status berhasil diperbarui.';
                                feedback.classList.remove('text-red-600', 'text-gray-500');
                                feedback.classList.add('text-green-600');
                            }

                            showToast(data.message || 'Status pesanan berhasil diperbarui.');
                        })
                        .catch((error) => {
                            let message = 'Gagal memperbarui status.';
                            if (error?.status === 422) {
                                const errors = error.data?.errors;
                                message = errors?.status?.[0] || error.data?.message || message;
                            } else if (error?.data?.message) {
                                message = error.data.message;
                            }

                            if (feedback) {
                                feedback.textContent = message;
                                feedback.classList.remove('text-green-600', 'text-gray-500');
                                feedback.classList.add('text-red-600');
                            }

                            showToast(message, 'error');
                        })
                        .finally(() => {
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.textContent = originalText || 'Simpan';
                            }

                            if (feedback) {
                                setTimeout(() => {
                                    feedback.textContent = '';
                                    feedback.classList.remove('text-green-600', 'text-red-600');
                                    feedback.classList.add('text-gray-500');
                                }, 3200);
                            }
                        });
                });
            });
        });
    </script>
</x-app-layout>
