<?php
declare(strict_types=1);
require_once 'data.php';
require_once 'functions.php';

// Menangkap parameter kategori yang diklik dari URL (menggunakan operator null coalescing, default 'Semua')
$kategoriAktif = $_GET['kategori'] ?? 'Semua';

// Menentukan daftar kategori yang tersedia untuk tombol filter di halaman web
$daftarKategori = ['Semua', 'Makanan', 'Snack', 'Dessert', 'Minuman Kopi', 'Minuman Non Kopi'];

// Proses penyaringan (filter) menu berdasarkan kategori yang sedang aktif dipilih
if ($kategoriAktif === 'Semua') {
    $menuDitampilkan = $daftarMenu; // Jika 'Semua', tampilkan seluruh data menu
} else {
    // Jika memilih kategori tertentu, saring array menggunakan fungsi array_filter
    $menuDitampilkan = array_filter($daftarMenu, fn($item) => $item['kategori'] === $kategoriAktif);
}

// Menghitung jumlah total menu yang sedang tampil di layar
$totalMenuTampil = count($menuDitampilkan);

// Menghitung rata-rata harga menu yang sedang ditampilkan (array_values digunakan untuk mereset indeks array setelah difilter)
$rataRataHarga = hitungRataRataHarga(array_values($menuDitampilkan));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - Kafe Senja</title>
    <!-- Menghubungkan file stylesheet eksternal untuk desain tampilan -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS internal untuk mempercantik komponen filter, card grid, dan kotak ringkasan */
        .filter-container { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; justify-content: center; }
        .filter-btn { padding: 0.5rem 1rem; border: 1px solid #cbd5e1; background: #fff; color: #334155; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
        .filter-btn:hover, .filter-btn.active { background: #0284c7; color: #fff; border-color: #0284c7; }
        
        .grid-menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-top: 1rem; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 9px; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Pengaturan gambar produk agar seragam menggunakan object-fit cover */
        .card img { width: 100%; height: 160px; object-fit: cover; object-position: center; background-color: #f8fafc; }
        
        .card-content { padding: 1.2rem; display: flex; flex-direction: column; flex-grow: 1; }
        .badge { display: inline-block; padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: bold; border-radius: 4px; margin-bottom: 0.5rem; align-self: flex-start; }
        .badge-tersedia { background-color: #d1fae5; color: #065f46; }
        .badge-habis { background-color: #fee2e2; color: #991b1b; }
        .summary-box { background: #e0f2fe; padding: 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; color: #0369a1; border-left: 4px solid #0284c7; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
    </style>
</head>
<body>
    <!-- Bagian Header Website -->
    <header>
        <h1>☕ Kafe Senja</h1>
        <p>Daftar Menu</p>
    </header>

    <!-- Bagian Navigasi Antarhalaman (dengan penanda class active) -->
    <nav>
        <a href="index.php">Profil Kafe</a>
        <a href="katalog.php" class="active">Daftar Menu</a>
    </nav>

    <main>
        <!-- Bagian Tombol Filter Kategori -->
        <section>
            <h2>Pilih Kategori Menu</h2>
            <div class="filter-container">
                <!-- Melakukan perulangan untuk mencetak tombol filter secara dinamis -->
                <?php foreach ($daftarKategori as $kat): ?>
                    <a href="katalog.php?kategori=<?= urlencode($kat) ?>" 
                       class="filter-btn <?= ($kategoriAktif === $kat) ? 'active' : '' ?>">
                        <?= $kat ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Kotak Ringkasan Statistik Data -->
            <div class="summary-box">
                <div>
                    <!-- Menampilkan kategori yang sedang aktif (menggunakan fungsi e() untuk keamanan XSS) -->
                    <p>Kategori Aktif: <strong><?= e($kategoriAktif) ?></strong></p>
                    <!-- Menampilkan jumlah total menu yang sedang tampil -->
                    <p>Jumlah Menu Ditampilkan: <strong><?= $totalMenuTampil ?> menu</strong></p>
                </div>
                <div>
                    <!-- Menampilkan hasil perhitungan rata-rata harga yang sudah diformat ke Rupiah -->
                    <p>Rata-rata Harga: <strong><?= formatRupiah((int)$rataRataHarga) ?></strong></p>
                </div>
            </div>
        </section>

        <!-- Bagian Daftar Kartu Menu Berdasarkan Hasil Filter -->
        <section>
            <h2>Daftar Menu (<?= e($kategoriAktif) ?>)</h2>
            
            <!-- Percabangan: Cek apakah data menu kosong atau tersedia -->
            <?php if (empty($menuDitampilkan)): ?>
                <p style="text-align: center; color: #64748b; padding: 2rem;">Belum ada menu pada kategori ini.</p>
            <?php else: ?>
                <div class="grid-menu">
                    <!-- Perulangan untuk menampilkan setiap item menu ke dalam bentuk card -->
                    <?php foreach ($menuDitampilkan as $menu): ?>
                        <div class="card">
                            <!-- Menampilkan gambar menu dengan aman menggunakan e() -->
                            <img src="<?= e($menu['foto']) ?>" alt="Foto menu <?= e($menu['nama']) ?>">
                            <div class="card-content">
                                <!-- Pengecekan status ketersediaan produk untuk badge -->
                                <?php if ($menu['tersedia']): ?>
                                    <span class="badge badge-tersedia">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge badge-habis">Kosong</span>
                                <?php endif; ?>
                                
                                <p style="font-size: 0.85rem; color: #64748b;"><?= e($menu['kategori']) ?></p>
                                <h3 style="font-size: 1.1rem; margin: 0.3rem 0;"><?= e($menu['nama']) ?></h3>
                                <!-- Menampilkan harga produk yang sudah diformat ke format Rupiah -->
                                <p style="font-weight: bold; color: #0284c7; margin-top: auto;"><?= formatRupiah($menu['harga']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Bagian Footer Website -->
    <footer>
        <p>&copy; 2026 Kafe Senja</p>
    </footer>
</body>
</html>