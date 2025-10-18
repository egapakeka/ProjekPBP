<header class="bg-white shadow-md fixed w-full z-50">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <a href="{{ url('/') }}" class="text-2xl font-bold text-primary">TokoKita</a>

            <nav class="space-x-6 hidden md:block">
            <a href="{{ route('products.index') }}" class="hover:text-primary">Produk</a>
            <!-- Point to landing page anchors so clicks from other pages scroll to the correct section -->
            <a href="{{ url('/#about') }}" class="hover:text-primary">Tentang</a>
            <a href="{{ url('/#faq') }}" class="hover:text-primary">FAQ</a>
            <a href="{{ url('/#help') }}" class="hover:text-primary">Bantuan</a>
        </nav>

        {{-- Guest: Login --}}
        @guest
            <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-orange-400">
                Login
            </a>
        @endguest

        {{-- Authenticated: Profil / Logout --}}
        @auth
            <a href="{{ route('profile.edit') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200">
                Profil Saya
            </a>

            {{-- Logout Form --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</header>

{{-- add spacing so page content doesn't hide under fixed header --}}
<div class="h-20"></div>
