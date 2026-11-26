<?php
$pageTitle = 'Dashboard Customer';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h2>Dashboard Customer</h2>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['user']['name']) ?>.</p>
    <p>Temukan film dan pesan tiket bioskop favoritmu.</p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>