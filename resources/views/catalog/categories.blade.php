<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Daftar Kategori</h2>
    </x-slot>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-6">
        @foreach ($categories as $category)
            <a href="{{ route('categories.show', $category->id) }}" 
               class="bg-white shadow p-4 rounded text-center hover:bg-gray-100">
                {{ $category->namaKategori }}
            </a>
        @endforeach
    </div>
</x-app-layout>
