
<?php
$pageTitle = $pageTitle ?? 'Dashboard Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> - Bioskop Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/bioskop/public/assets/css/style.css">
    <link rel="stylesheet" href="/bioskop/public/assets/css/admin.css">
</head>

<body>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar">

        <div class="sidebar-brand">
            <h4>BIOSKOP</h4>
            <small>ADMIN PANEL</small>
        </div>

        <nav class="sidebar-menu">

            <a href="/bioskop/public/admin" class="active">
                Dashboard
            </a>

            <div class="sidebar-label">MANAJEMEN BIOSKOP</div>

            <a href="/bioskop/public/admin/movies">Data Film</a>
            <a href="#">Genre Film</a>
            <a href="#">Studio</a>
            <a href="#">Kursi</a>
            <a href="#">Jadwal Tayang</a>

            <div class="sidebar-label">MANAJEMEN LAINNYA</div>

            <a href="#">Promosi & Voucher</a>
            <a href="#">Pengguna</a>
            <a href="#">Transaksi</a>
            <a href="#">Laporan</a>

        </nav>

        <div class="sidebar-bottom">
            <a href="/bioskop/public/logout" class="logout-link">
                Logout
            </a>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="admin-main">

        <header class="admin-navbar">
            <h5><?= htmlspecialchars($pageTitle) ?></h5>

            <div class="admin-profile">
                Halo,
                <strong>
                    <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </strong>
            </div>
        </header>

        <div class="admin-content">
