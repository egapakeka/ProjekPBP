@php($admin = $admin ?? auth()->user())

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Admin Utama') }}
            </h2>

            <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">
                {{ __('Admin') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Informasi Utama') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Perbarui informasi akun administrator di bawah ini.') }}
                    </p>
                </div>
                <div class="px-6 py-6 space-y-8">
                    <dl class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-lg bg-gray-50 px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Nama Lengkap') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $admin->name }}</dd>
                        </div>

                        <div class="rounded-lg bg-gray-50 px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Email') }}</dt>
                            <dd class="mt-1 break-all text-base text-gray-900">{{ $admin->email }}</dd>
                        </div>

                        <div class="rounded-lg bg-gray-50 px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Role') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ ucfirst($admin->role) }}</dd>
                        </div>

                        <div class="rounded-lg bg-gray-50 px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Nomor Kontak') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $admin->phone ?? __('Belum diatur') }}</dd>
                        </div>

                        <div class="sm:col-span-2 rounded-lg bg-gray-50 px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Alamat') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $admin->address ?? __('Belum diatur') }}</dd>
                        </div>
                    </dl>

                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc space-y-1 pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="border-t border-dashed border-gray-200 pt-6">
                        <h4 class="text-lg font-semibold text-gray-900">{{ __('Edit Profil') }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Perbarui data akun admin sesuai kebutuhan.') }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.profile.update') }}" class="grid gap-6 sm:grid-cols-2">
                        @csrf
                        @method('PATCH')

                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nama Lengkap') }}</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $admin->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $admin->email) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                            <p class="mt-2 rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700">
                                {{ ucfirst($admin->role) }}
                            </p>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Nomor Kontak') }}</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $admin->phone) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Alamat') }}</label>
                            <textarea id="address" name="address" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">{{ old('address', $admin->address) }}</textarea>
                        </div>

                        <div class="sm:col-span-2 flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Aktivitas Akun') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Riwayat waktu pembuatan dan pembaruan akun admin.') }}
                    </p>
                </div>
                <div class="px-6 py-6">
                    <dl class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Akun Dibuat') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ optional($admin->created_at)->translatedFormat('d F Y H:i') ?? __('Tidak tersedia') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Terakhir Diperbarui') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ optional($admin->updated_at)->translatedFormat('d F Y H:i') ?? __('Tidak tersedia') }}
                            </dd>
                        </div>
                    </dl>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
