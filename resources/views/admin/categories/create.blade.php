<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kategori
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama Kategori</label>
                <input type="text" name="name"
                       class="form-input mt-1 block w-full border rounded p-2"
                       value="{{ old('name') }}" required>
            </div>

            <button type="submit"
                    class="btn btn-primary px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary px-4 py-2 ml-2 bg-gray-500 text-white rounded">
               Batal
            </a>
        </form>
    </div>
</x-app-layout>
