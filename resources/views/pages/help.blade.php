<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <i class="fa-solid fa-headset text-purple-600"></i> Halaman Bantuan
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="bg-white p-6 shadow rounded">
            <h3 class="font-bold text-lg flex items-center gap-2 mb-3">
                <i class="fa-solid fa-envelope text-blue-600"></i> Hubungi Kami
            </h3>
            @if(session('status'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 mb-4">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('help.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Pesan</label>
                    <textarea name="message" rows="4" class="w-full border rounded px-3 py-2">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
            </form>
        </div>

        <div class="bg-white p-6 shadow rounded">
            <h3 class="font-bold text-lg flex items-center gap-2 mb-3">
                <i class="fa-solid fa-phone text-green-600"></i> Customer Service
            </h3>
            <p class="text-gray-700">Hubungi CS kami di: <b>+62 812-3456-7890</b></p>
        </div>
    </div>
</x-app-layout>
