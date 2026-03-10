<?php
session_start();

// ---- CEK SESSION / COOKIE ----
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Coba auto-login via cookie remember me
    $cookieName = 'danscupang_remember';
    if (isset($_COOKIE[$cookieName])) {
        $decoded = base64_decode($_COOKIE[$cookieName]);
        if ($decoded !== false) {
            $parts      = explode(':', $decoded, 2);
            $cookieUser = $parts[0] ?? '';
            $validUsers = ['admin', 'dan']; // samakan dengan controller.php

            if (in_array($cookieUser, $validUsers, true)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username']  = $cookieUser;
            } else {
                header('Location: login.php'); exit;
            }
        } else {
            header('Location: login.php'); exit;
        }
    } else {
        header('Location: login.php'); exit;
    }
}

$username = htmlspecialchars($_SESSION['username']);
$initial  = strtoupper($username[0]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dan's Cupang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />

    <!-- Style tambahan HANYA untuk user badge & tombol logout -->
    <style>
        .user-badge {
            background: rgba(0,201,177,0.12);
            border: 1px solid rgba(0,201,177,0.3);
            border-radius: 20px;
            padding: 5px 13px;
            color: #00c9b1;
            font-size: 0.83rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .user-avatar {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #00c9b1, #00a896);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700;
            color: #0d2233; flex-shrink: 0;
        }
        .btn-logout-nav {
            background: transparent;
            border: 1px solid rgba(220,53,69,0.4);
            color: #ff8a8a;
            border-radius: 20px;
            padding: 5px 13px;
            font-size: 0.82rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout-nav:hover {
            background: rgba(220,53,69,0.1);
            border-color: #dc3545;
            color: #ff6b6b;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ================================================================
     NAVBAR — sama persis dengan index.html kamu
     Hanya ditambah: user badge + tombol logout di sebelah btn-theme
     ================================================================ -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">DAN'S CUPANG</a>
    </div>
        <!-- Tambahan: user badge + logout -->
        <div class="d-flex align-items-center gap-2 me-2">
            <div class="user-badge">
                <div class="user-avatar"><?= $initial ?></div>
                <span><?= $username ?></span>
            </div>
            <button class="btn-logout-nav" data-bs-toggle="modal" data-bs-target="#logoutModal">
                Keluar ↩
            </button>
            <!-- btn-theme sudah ada di index.html kamu -->
            <button id="btn-theme" class="btn btn-outline-light btn-sm">
                Mode Gelap
            </button>
        </div>
    <div>
</div>
</nav>

<!-- ================================================================
     SEMUA KONTEN DI BAWAH INI COPY-PASTE DARI index.html KAMU
     Tidak ada yang diubah
     ================================================================ -->

<section class="hero text-white">
    <div class="container text-center">
        <h2>Sistem Jual Beli Cupang</h2>
        <p class="lead mb-4">Ikan Cupang terbaik dengan warna yang indah</p>
    </div>
</section>

<!-- Content -->
<div class="container my-4">

    <!-- Statistik -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Jenis Ikan</h6>
                    <h3>12</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Stok Tersedia</h6>
                    <h3>85</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Jenis</h6>
                    <h3>3</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Judul -->
    <h4 class="mb-3">Cupang Champions</h4>
    <div class="container mt-5">
    <h3 class="mb-4">Daftar Ikan</h3>
    <div class="row" id="container-barang">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="images/Cupang_20juta.png" class="card-img-top" alt="Ikan">
                <div class="card-body">
                    <h5 class="card-title">Kachen Worachai</h5>
                    <p class="card-text harga-text">Harga: Rp 20900000</p>
                    <p class="card-text stok-text">Stok: 2</p>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                        <button class="btn btn-outline-danger btn-wishlist w-50">💖 Wishlist</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="wishlistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Wishlist Saya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="daftar-wishlist">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="hapusWishlist()">Kosongkan</button>
            </div>
        </div>
    </div>
</div>

    <!-- Card Produk -->
    <div class="row g-4">

        <!-- Produk 1 -->
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/Cupang_20juta.png" class="card-img-top" alt="Ikan">
                <div class="card-body">
                    <h6 class="card-title">Kachen Worachai</h6>
                    <p class="mb-1">Harga: Rp 20.900.000</p>
                    <p class="text-muted">Stok: 2</p>
                    <a href="#" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>

        <!-- Produk 2 -->
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/Cupang_8juta.png" class="card-img-top" alt="Ikan">
                <div class="card-body">
                    <h6 class="card-title">Plakat Sultan/Inasa Aurora</h6>
                    <p class="mb-1">Harga: Rp 8.200.000</p>
                    <p class="text-muted">Stok: 5</p>
                    <a href="#" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>

        <!-- Produk 3 -->
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/Cupang_1juta.png" class="card-img-top" alt="Ikan">
                <div class="card-body">
                    <h6 class="card-title">Halfmoon Avatar/Koi</h6>
                    <p class="mb-1">Harga: Rp 1.799.000</p>
                    <p class="text-muted">Stok: 10</p>
                    <a href="#" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto border-top">
    <small>© 2026 Dan's Cupang — Login sebagai: <span style="color:#00c9b1"><?= $username ?></span></small>
</footer>

<!-- ================================================================
     MODAL LOGOUT — ditambahkan di sini, tidak mengganggu konten lain
     ================================================================ -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:360px">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body text-center py-4 px-4">
                <div style="font-size:2.6rem;margin-bottom:10px">👋</div>
                <h5 class="fw-bold mb-2">Keluar dari akun?</h5>
                <p class="text-muted small mb-4">Kamu akan diarahkan kembali ke halaman login.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="controller.php?action=logout">
                        <button type="submit" class="btn btn-danger px-4">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>