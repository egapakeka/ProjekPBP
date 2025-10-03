<!DOCTYPE html>
<html>
<head>
    <title>Katalog Produk</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <h1>Daftar Produk</h1>
    <div class="product-list" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card" style="border:1px solid #ddd; padding:15px; border-radius:10px;">
                    <h2><?= htmlspecialchars($p['name']); ?></h2>
                    <p>Kategori: <?= htmlspecialchars($p['category']); ?></p>
                    <p>Harga: Rp<?= number_format($p['price'], 0, ',', '.'); ?></p>
                    <p>Stok: <?= $p['stock']; ?></p>
                    <button>Tambah ke Keranjang</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada produk tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>
