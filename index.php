<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kafe - Kafe Senja</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .cafe-banner {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .info-card {
            background: #f8fafc;
            padding: 1.2rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <header>
        <h1>☕ Kafe Senja</h1>
        <p>Tempat terbaik menikmati secangkir kopi dan suasana hangat</p>
    </header>
    
    <nav>
        <a href="index.php" class="active">Profil Kafe</a>
        <a href="katalog.php">Daftar Menu</a>
    </nav>

    <main>
        <section class="profile-container">
            <h2>Tentang Kafe Senja</h2>
            
            <!-- Foto / Suasana Kafe -->
            <img src="assets/suasana-kafe.jpg" alt="Suasana interior Kafe Senja yang nyaman dan estetik" class="cafe-banner">

            <!-- PERBAIKAN: Menambahkan tag penutup </p> -->
            <p>Selamat datang di halaman resmi <strong>Kafe Senja</strong>. Kami menyajikan berbagai pilihan menu berkualitas
             mulai dari hidangan utama, snack, dessert, hingga aneka racikan kopi dan non-kopi untuk menemani waktu produktif maupun bersantai Anda.</p>
            
            <div class="info-grid">
                <div class="info-card">
                    <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem;">🕒 Jam Operasional</h3>
                    <p>Senin - Minggu</p>
                    <p>10.00 - 23.00 WIB</p>
                </div>
                <div class="info-card">
                    <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem;">📍 Lokasi Kami</h3>
                    <p>Jl. Kenangan No. 45</p>
                    <p>Surakarta, Jawa Tengah</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Fakultas Teknik - Informatika S1 | Tiga Serangkai University</p>
    </footer>
</body>
</html>