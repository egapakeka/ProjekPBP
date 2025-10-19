<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKita - Landing Page</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mainLogo/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/mainLogo/logo.png') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    @include('layouts.navigation')

    {{-- Hero --}}
    <section class="pt-28 pb-20 bg-primary text-white text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Belanja Lebih Mudah di TokoKita</h1>
            <p class="text-lg md:text-xl mb-8">Dapatkan produk terbaik dengan harga terjangkau, hanya di TokoKita.</p>
            <a href="#products" class="bg-white text-primary font-semibold px-6 py-3 rounded-lg hover:bg-gray-200">
                Lihat Produk
            </a>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section id="products" class="py-12 bg-gray-50 scroll-mt-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-6">Produk Unggulan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $product->description }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-orange-500 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">
                                    <i class="fa-solid fa-fire mr-1 text-orange-500"></i>
                                    Terjual {{ number_format($product->total_sold ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <button
                                type="button"
                                class="inline-flex items-center justify-center mt-3 bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded transition focus:outline-none focus:ring-2 focus:ring-orange-300"
                                data-product-detail
                                data-product-name="{{ e($product->name) }}"
                                data-product-description="{{ e($product->description) }}"
                                data-product-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
                                data-product-image="{{ $product->image ? asset('storage/'.$product->image) : asset('images/mainLogo/logo.png') }}"
                                data-product-category="{{ e(optional($product->category)->name ?? 'Umum') }}"
                                data-product-stock="{{ $product->stock }}"
                                data-product-sold="{{ number_format($product->total_sold ?? 0, 0, ',', '.') }}"
                            >
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="about" class="py-20 bg-gray-100 scroll-mt-28">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Tentang TokoKita</h2>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Marketplace Kampus UNDIP dibuat oleh mahasiswa, untuk mahasiswa. Kami hadir memberikan solusi belanja
                    kebutuhan kuliah, teknologi, hingga gaya hidup harian dengan harga yang ramah kantong.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div id="about-profile" class="bg-white shadow-sm rounded-xl p-6 text-center scroll-mt-28">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <i class="fa-solid fa-building text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Profil Perusahaan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        TokoKita adalah marketplace yang lahir dari kampus UNDIP, fokus menghadirkan pengalaman belanja online
                        yang mudah, aman, dan terpercaya untuk seluruh civitas akademika.
                    </p>
                </div>

                <div id="about-vision" class="bg-white shadow-sm rounded-xl p-6 text-center scroll-mt-28">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600 mb-4">
                        <i class="fa-solid fa-bullseye text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Visi &amp; Misi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Menjadi platform utama mahasiswa dalam memenuhi kebutuhan sehari-hari dengan proses cepat,
                        harga terjangkau, dan dukungan layanan pelanggan yang sigap.
                    </p>
                </div>

                <div id="about-team" class="bg-white shadow-sm rounded-xl p-6 text-center scroll-mt-28">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600 mb-4">
                        <i class="fa-solid fa-people-group text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Tim Kami</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Dioperasikan oleh mahasiswa Informatika UNDIP yang berkomitmen menghadirkan inovasi dan kolaborasi
                        demi kemajuan ekosistem digital kampus.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-20 bg-white scroll-mt-28">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-4">FAQ - Pertanyaan Umum</h2>
            <p class="max-w-3xl mx-auto text-center text-gray-600 mb-10">
                Temukan jawaban cepat seputar pengiriman, pembayaran, dan layanan kami.
            </p>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center gap-2 text-gray-900">
                        <i class="fa-solid fa-truck text-green-600"></i>
                        Bagaimana pengiriman dilakukan?
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Pengiriman dilakukan melalui kurir resmi dengan estimasi 2-5 hari kerja, tergantung lokasi tujuan.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center gap-2 text-gray-900">
                        <i class="fa-solid fa-credit-card text-yellow-600"></i>
                        Metode pembayaran apa saja yang tersedia?
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Kami menerima transfer bank, e-wallet populer, serta pembayaran COD untuk wilayah tertentu.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center gap-2 text-gray-900">
                        <i class="fa-solid fa-rotate-left text-red-500"></i>
                        Apakah bisa mengembalikan barang?
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Bisa. Ajukan permohonan retur maksimal 7 hari setelah barang diterima dengan menyertakan bukti kondisi produk.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center gap-2 text-gray-900">
                        <i class="fa-solid fa-headset text-blue-600"></i>
                        Bagaimana cara menghubungi layanan pelanggan?
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Tim support kami siap membantu melalui email, WhatsApp, dan live chat di jam kerja Senin-Jumat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak ringkas --}}
    <section id="help" class="py-20 container mx-auto px-6 scroll-mt-28">
        <h2 class="text-3xl font-bold text-center mb-6">Hubungi Kami</h2>
        <p class="max-w-2xl mx-auto text-center text-gray-600 mb-8">
            Punya saran atau keluhan? Sampaikan langsung dari sini, tim kami akan segera menindaklanjuti.
        </p>
        <div class="max-w-xl mx-auto">
            @if(session('status'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('help.submit') }}" method="POST" class="space-y-6 bg-white shadow-md rounded-xl p-6">
                @csrf
                <div>
                    <label for="help-name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input
                        type="text"
                        id="help-name"
                        name="name"
                        value="{{ old('name') }}"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-primary focus:ring-primary"
                        placeholder="Nama lengkap Anda"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="help-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        id="help-email"
                        name="email"
                        value="{{ old('email') }}"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-primary focus:ring-primary"
                        placeholder="Email aktif"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="help-message" class="block text-sm font-medium text-gray-700">Pesan</label>
                    <textarea id="help-message" name="message" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-primary focus:ring-primary" placeholder="Tulis pesan atau keluhan Anda di sini...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="w-full rounded-lg bg-primary py-3 text-center text-white font-semibold hover:bg-indigo-700 transition"
                >
                    <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Keluhan
                </button>
            </form>
        </div>
    </section>

    {{-- Modal Detail Produk --}}
    <div
        id="product-detail-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-8 flex"
        aria-hidden="true"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" data-modal-overlay></div>
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="absolute right-4 top-4">
                <button
                    type="button"
                    class="rounded-full bg-gray-100 p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary"
                    aria-label="Tutup detail produk"
                    data-modal-close
                >
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="grid gap-6 md:grid-cols-[1.1fr,1.2fr]">
                <div class="md:h-full">
                    <img
                        src=""
                        alt="Produk"
                        class="h-64 w-full object-cover md:h-full"
                        data-modal-image
                    >
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-1">
                        <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary" data-modal-category></span>
                        <h3 class="text-2xl font-semibold text-gray-900" data-modal-name></h3>
                    </div>
                    <p class="text-primary text-xl font-bold" data-modal-price></p>
                    <p class="text-gray-600 text-sm leading-relaxed" data-modal-description></p>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-fire text-orange-500"></i>
                            <span data-modal-sold></span>
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-boxes-stacked text-primary"></i>
                            <span data-modal-stock></span>
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a
                            href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-primary px-4 py-2 text-sm font-semibold text-primary hover:bg-primary hover:text-white transition"
                        >
                            Telusuri Produk Lain
                        </a>
                        <a
                            href="{{ route('cart.index') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
                        >
                            Lihat Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enable smooth scrolling for in-page anchors --}}
    <style>
        html { scroll-behavior: smooth; }
        /* If Tailwind config doesn't include scroll-margin, use utility fallback */
        .scroll-mt-28 { scroll-margin-top: 7rem; }
    </style>

    {{-- Footer default (FAQ / Bantuan / Tentang) --}}
    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('[data-product-detail]');
            if (!buttons.length) {
                return;
            }

            const modal = document.getElementById('product-detail-modal');
            const overlay = modal?.querySelector('[data-modal-overlay]');
            const closeBtn = modal?.querySelector('[data-modal-close]');

            const imageEl = modal?.querySelector('[data-modal-image]');
            const nameEl = modal?.querySelector('[data-modal-name]');
            const priceEl = modal?.querySelector('[data-modal-price]');
            const descriptionEl = modal?.querySelector('[data-modal-description]');
            const stockEl = modal?.querySelector('[data-modal-stock]');
            const categoryEl = modal?.querySelector('[data-modal-category]');
            const soldEl = modal?.querySelector('[data-modal-sold]');

            const openModal = (button) => {
                if (!modal) return;

                const {
                    productName,
                    productPrice,
                    productDescription,
                    productImage,
                    productStock,
                    productCategory,
                    productSold,
                } = button.dataset;

                if (imageEl && productImage) {
                    imageEl.src = productImage;
                    imageEl.alt = productName || 'Produk';
                }
                if (nameEl) nameEl.textContent = productName || 'Produk';
                if (priceEl) priceEl.textContent = productPrice || '-';
                if (descriptionEl) descriptionEl.textContent = productDescription || 'Deskripsi belum tersedia.';
                const stockValue = productStock ?? '-';
                const soldValue = productSold && productSold.trim() !== '' ? productSold : '0';

                if (stockEl) stockEl.textContent = `Stok tersedia: ${stockValue}`;
                if (categoryEl) categoryEl.textContent = productCategory || 'Produk';
                if (soldEl) soldEl.textContent = `Terjual ${soldValue}`;

                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => openModal(button));
            });

            overlay?.addEventListener('click', closeModal);
            closeBtn?.addEventListener('click', closeModal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal?.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>

</body>
</html>
