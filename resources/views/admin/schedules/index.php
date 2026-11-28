<?php
$pageTitle = 'Manajemen Jadwal Tayang';

require_once __DIR__ . '/../../layouts/admin_header.php';

$statusLabels = [
    'scheduled' => 'Terjadwal',
    'cancelled' => 'Dibatalkan',
    'completed' => 'Selesai'
];
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Jadwal Tayang</h2>
            <p class="text-secondary">
                Atur waktu tayang, studio, dan harga tiket setiap film.
            </p>
        </div>
        <a href="/bioskop/public/admin/schedules/create" class="btn btn-danger">
            + Tambah Jadwal
        </a>
    </div>

    <?php if ($error === 'conflict'): ?>
        <div class="alert alert-danger" role="alert">
            Jadwal bertabrakan dengan jadwal lain di studio yang sama.
        </div>
    <?php elseif ($error === 'related'): ?>
        <div class="alert alert-warning" role="alert">
            Jadwal ini memiliki booking sehingga tidak dapat dihapus. Ubah statusnya menjadi dibatalkan bila diperlukan.
        </div>
    <?php elseif ($error === 'filter'): ?>
        <div class="alert alert-warning" role="alert">
            Filter tanggal atau status tidak valid; daftar ditampilkan tanpa filter yang salah.
        </div>
    <?php elseif ($error === 'missing'): ?>
        <div class="alert alert-warning" role="alert">Jadwal tidak ditemukan.</div>
    <?php endif; ?>

    <?php if ($success === 'created'): ?>
        <div class="alert alert-success" role="alert">Jadwal tayang berhasil ditambahkan.</div>
    <?php elseif ($success === 'updated'): ?>
        <div class="alert alert-success" role="alert">Jadwal tayang berhasil diperbarui.</div>
    <?php elseif ($success === 'deleted'): ?>
        <div class="alert alert-success" role="alert">Jadwal tayang berhasil dihapus.</div>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary mb-4">
        <div class="card-body">
            <form action="/bioskop/public/admin/schedules" method="GET" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">Tanggal Tayang</label>
                    <input type="date" id="date" name="date" class="form-control"
                           value="<?= htmlspecialchars($date) ?>">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <?php foreach ($statusLabels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    <a href="/bioskop/public/admin/schedules" class="btn btn-outline-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Film</th>
                            <th>Studio</th>
                            <th>Waktu Tayang</th>
                            <th>Harga Tiket</th>
                            <th>Booking</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $index => $schedule): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($schedule['movie_title']) ?></strong>
                                        <div class="small text-secondary">
                                            <?= (int) $schedule['movie_duration'] ?> menit
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($schedule['studio_name']) ?></td>
                                    <td>
                                        <?= htmlspecialchars(date('d/m/Y H:i', strtotime($schedule['start_at']))) ?>
                                        <div class="small text-secondary">
                                            s/d <?= htmlspecialchars(date('H:i', strtotime($schedule['end_at']))) ?>
                                        </div>
                                    </td>
                                    <td>Rp <?= number_format((float) $schedule['price'], 0, ',', '.') ?></td>
                                    <td><?= (int) $schedule['booking_count'] ?></td>
                                    <td>
                                        <?php if ($schedule['status'] === 'scheduled'): ?>
                                            <span class="badge bg-success"><?= $statusLabels[$schedule['status']] ?></span>
                                        <?php elseif ($schedule['status'] === 'cancelled'): ?>
                                            <span class="badge bg-danger"><?= $statusLabels[$schedule['status']] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= $statusLabels[$schedule['status']] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/bioskop/public/admin/schedules/edit?id=<?= (int) $schedule['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            Detail / Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-secondary">
                                    Belum ada jadwal tayang untuk filter ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
