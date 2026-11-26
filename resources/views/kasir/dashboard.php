<?php
$pageTitle = 'Dashboard Kasir';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h2>Dashboard Kasir</h2>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['user']['name']) ?>.</p>
    <p>Kelola penjualan tiket dan pemindaian tiket pelanggan.</p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>