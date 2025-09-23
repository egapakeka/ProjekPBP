<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Kategori
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-primary mb-3">+ Tambah Kategori</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Nama Kategori</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
