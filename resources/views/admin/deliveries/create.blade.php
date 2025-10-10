<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pengiriman</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.deliveries.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
                @csrf

                <div>
                    <label for="order_id">Pesanan</label>
                    <select name="order_id" id="order_id" class="w-full border-gray-300 rounded">
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}">Pesanan #{{ $order->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-3">
                    <label>Kurir</label>
                    <input type="text" name="kurir" class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mt-3">
                    <label>No. Resi</label>
                    <input type="text" name="no_resi" class="w-full border-gray-300 rounded">
                </div>

                <div class="mt-3">
                    <label>Status</label>
                    <select name="status_pengiriman" class="w-full border-gray-300 rounded">
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
