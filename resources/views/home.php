<?php
$pageTitle = 'Beranda';
require_once __DIR__ . '/layouts/header.php';
?>

<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold text-red" href="/bioskop/public/">
            BIOSKOP
        </a>
        <div>
            <?php if (isset($_SESSION['user'])): ?>

                <span class="text-white me-3">
                    Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </span>

                <a href="/bioskop/public/logout" class="btn btn-danger">
                    Logout
                </a>

            <?php else: ?>

                <a href="/bioskop/public/login" class="btn btn-outline-light">
                    Login
                </a>

                <a href="/bioskop/public/register" class="btn btn-red">
                    Daftar
                </a>

            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container text-center py-5">
    <h1 class="display-4 fw-bold">
        Selamat Datang di Bioskop
    </h1>

    <p class="lead text-secondary">
        Sistem Pemesanan Tiket Bioskop Online
    </p>

    <a href="/bioskop/public/login" class="btn btn-red btn-lg mt-3">
        Pesan Tiket Sekarang
    </a>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
