<?php
/**
 * @var int $totalMovies
 * @var int $totalTransactions
 * @var int $totalTickets
 * @var float $totalRevenue
 */

$pageTitle = 'Dashboard Admin';

require_once __DIR__ . '/../layouts/admin_header.php';
?>

<h2 class="mb-2">Dashboard Admin</h2>

<p class="text-secondary">
    Selamat datang di panel pengelolaan bioskop.
</p>

<div class="row mt-4">

    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <h6 class="text-secondary">Total Film</h6>
                <h2><?= $totalMovies ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <h6 class="text-secondary">Total Transaksi</h6>
                <h2><?= $totalTransactions ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <h6 class="text-secondary">Tiket Terjual</h6>
                <h2><?= $totalTickets ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <h6 class="text-secondary">Total Pendapatan</h6>
                <h5 class="text-success mt-2">
                    Rp <?= number_format((float) $totalRevenue, 0, ',', '.') ?>
                </h5>
            </div>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../layouts/admin_footer.php';
?>
