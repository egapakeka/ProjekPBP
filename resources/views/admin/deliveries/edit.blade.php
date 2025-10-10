<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Status Pengiriman</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.deliveries.update', $delivery->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
                @csrf
                @method('PUT')

                <div>
                    <label>Kurir</label>
                    <input type="text" name="kurir" value="{{ $delivery->kurir }}" class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mt-3">
                    <label>No. Resi</label>
                    <input type="text" name="no_resi" value="{{ $delivery->no_resi }}" class="w-full border-gray-300 rounded">
                </div>

                <div class="mt-3">
                    <label>Status Pengiriman</label>
                    <select name="status_pengiriman" class="w-full border-gray-300 rounded">
                        @foreach (['diproses', 'dikirim', 'selesai', 'batal'] as $status)
                            <option value="{{ $status }}" {{ $delivery->status_pengiriman == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
