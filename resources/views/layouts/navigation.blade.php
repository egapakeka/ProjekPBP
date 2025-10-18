<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Search (desktop) -->
                <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex items-center space-x-2">
                    <div class="flex items-center space-x-2 rounded-lg border border-gray-300 bg-white px-3 py-1">
                        <i class="fas fa-search text-gray-400"></i>
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari produk..."
                            value="{{ request('search') }}"
                            class="w-56 border-0 bg-transparent text-sm focus:outline-none focus:ring-0"
                        >
                    </div>
                    <button type="submit" class="hidden">
                        {{ __('Cari') }}
                    </button>
                </form>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 md:ms-6 md:flex items-center">
                    @php($user = auth()->user())
                    @php($isAdmin = $user && $user->role === 'admin')

                    @if($isAdmin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Ubah Kategori') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Ubah Produk') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Pesanan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.vouchers.index')" :active="request()->routeIs('admin.vouchers.*')">
                            {{ __('Voucher') }}
                        </x-nav-link>

                    @else
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium hover:text-primary">
                            {{ __('Produk') }}
                        </a>
                        <a href="{{ url('/#about') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium hover:text-primary">
                            {{ __('Tentang') }}
                        </a>
                        <a href="{{ url('/#help') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium hover:text-primary">
                            {{ __('Bantuan') }}
                        </a>
                        <a href="{{ url('/#faq') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium hover:text-primary">
                            {{ __('FAQ') }}
                        </a>
                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            @php($cartCount = auth()->check() ? (auth()->user()->cart?->items()->sum('qty') ?? 0) : 0)
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @auth
                    @php($user = auth()->user())
                    @php($isAdmin = $user->role === 'admin')

                    @if(!$isAdmin)
                        <a href="{{ route('orders.index') }}" class="relative inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                            <i class="fas fa-box mr-2" style="font-size: 19px;"></i>
                        </a>
                        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                            <i class="fas fa-shopping-cart mr-2" style="font-size: 19px;"></i>
                            <span data-cart-count-badge class="ml-2 inline-flex items-center rounded-full bg-primary px-2 py-0.5 text-xs font-semibold text-gray-700 {{ $cartCount > 0 ? '' : 'hidden' }}">
                                <span data-cart-count-value>{{ $cartCount }}</span>
                            </span>
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                                <div>{{ $user->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="$isAdmin ? route('admin.profile.edit') : route('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="relative inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                        <i class="fas fa-box mr-2" style="font-size: 19px;"></i>
                    </a>
                    <a href="{{ route('login') }}" class="relative inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-primary">
                        <i class="fas fa-shopping-cart mr-2" style="font-size: 19px;"></i>
                        <span data-cart-count-badge class="ml-2 inline-flex items-center rounded-full bg-primary px-2 py-0.5 text-xs font-semibold text-gray-700 hidden">
                            <span data-cart-count-value>0</span>
                        </span>
                    </a>
                    <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-400">
                        {{ __('Login') }}
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (!Request::is('admin*'))
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    {{ __('Produk') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>
            @endif

            <form action="{{ route('products.index') }}" method="GET" class="px-4 py-2">
                <div class="flex items-center space-x-2">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari produk..." 
                        value="{{ request('search') }}" 
                        class="w-full border rounded px-3 py-1 text-sm focus:outline-none"
                    >
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Cari
                    </button>
                </div>
            </form>

            <!-- Tentang & Bantuan (link to landing anchors) -->
            <x-responsive-nav-link :href="url('/#about')">
                {{ __('Tentang') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/#help')">
                {{ __('Bantuan') }}
            </x-responsive-nav-link>

            <!-- Menu Admin (hanya jika login) -->
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Ubah Kategori') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        {{ __('Ubah Produk') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        {{ __('Pesanan') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.vouchers.index')" :active="request()->routeIs('admin.vouchers.*')">
                        {{ __('Voucher') }}
                    </x-responsive-nav-link>

                @else
                    @php($cartCount = auth()->user()->cart?->items()->sum('qty') ?? 0)
                    <x-responsive-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                        {{ __('Produk') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('landing') }}#about">
                        {{ __('Tentang') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('landing') }}#help">
                        {{ __('Bantuan') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ url('/#faq') }}" :active="request()->routeIs('landing')">
                        {{ __('FAQ') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.*')">
                        {{ __('Keranjang') }}
                        <span data-cart-count-badge class="ml-2 inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary {{ $cartCount > 0 ? '' : 'hidden' }}">
                            <span data-cart-count-value>{{ $cartCount }}</span>
                        </span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                @endif

            @else
                <x-responsive-nav-link href="{{ route('login') }}">
                    {{ __('Keranjang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('login') }}">
                    {{ __('Pesanan Saya') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    @php($user = auth()->user())
                    @php($isAdmin = $user->role === 'admin')
                    <div class="font-medium text-base text-gray-800">{{ $user->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $user->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="$isAdmin ? route('admin.profile.edit') : route('profile.edit')">
                        {{ __('Profil Saya') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 pb-4">
                    <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-orange-400">
                        {{ __('Login') }}
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
