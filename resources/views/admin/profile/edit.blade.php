<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Admin
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 space-y-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Ubah Profil</h3>
            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="border rounded w-full px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="border rounded w-full px-3 py-2">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Ganti Password</h3>
            <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" class="border rounded w-full px-3 py-2" autocomplete="current-password">
                </div>
                <div>
                    <label class="block text-sm mb-1">Password Baru</label>
                    <input type="password" name="password" class="border rounded w-full px-3 py-2" autocomplete="new-password">
                </div>
                <div>
                    <label class="block text-sm mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="border rounded w-full px-3 py-2" autocomplete="new-password">
                </div>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Ganti Password</button>
            </form>
        </div>
    </div>
</x-app-layout>
