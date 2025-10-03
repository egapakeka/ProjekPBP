<footer class="bg-gray-100 border-t border-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- FAQ -->
        <div>
            <h3 class="text-lg font-semibold mb-3">FAQ</h3>
            <ul class="space-y-2">
                <li><a href="{{ url('/faq') }}" class="text-gray-600 hover:text-gray-900">Pertanyaan Umum</a></li>
                <li><a href="{{ url('/faq#pengiriman') }}" class="text-gray-600 hover:text-gray-900">Pengiriman</a></li>
                <li><a href="{{ url('/faq#pembayaran') }}" class="text-gray-600 hover:text-gray-900">Pembayaran</a></li>
            </ul>
        </div>

        <!-- Halaman Bantuan -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Bantuan</h3>
            <ul class="space-y-2">
                <li><a href="{{ url('/help') }}" class="text-gray-600 hover:text-gray-900">Hubungi Kami</a></li>
                <li><a href="{{ url('/help#cs') }}" class="text-gray-600 hover:text-gray-900">Customer Service</a></li>
                <li><a href="{{ url('/help#pengembalian') }}" class="text-gray-600 hover:text-gray-900">Pengembalian Barang</a></li>
            </ul>
        </div>

        <!-- Tentang Kami -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Tentang Kami</h3>
            <ul class="space-y-2">
                <li><a href="{{ url('/about') }}" class="text-gray-600 hover:text-gray-900">Profil Perusahaan</a></li>
                <li><a href="{{ url('/about#visi') }}" class="text-gray-600 hover:text-gray-900">Visi & Misi</a></li>
                <li><a href="{{ url('/about#tim') }}" class="text-gray-600 hover:text-gray-900">Tim Kami</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-300 text-center py-4 text-sm text-gray-600">
        © {{ date('Y') }} Marketplace Kampus UNDIP. Semua Hak Dilindungi.
    </div>
</footer>
