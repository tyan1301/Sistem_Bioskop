<?php
/**
 * @var array $schedule
 */

$pageTitle = 'Detail Jadwal Tayang';

require_once __DIR__ . '/../../layouts/admin_header.php';

$statusLabels = [
    'scheduled' => 'Terjadwal',
    'cancelled' => 'Dibatalkan',
    'completed' => 'Selesai'
];
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Detail Jadwal Tayang</h2>
        <p class="text-secondary">
            Kelola informasi film, studio, waktu, harga, dan status jadwal.
        </p>
    </div>

    <?php if ($scheduleHasBookings): ?>
        <div class="alert alert-warning" role="alert">
            Jadwal ini sudah memiliki booking. Film, studio, waktu, dan harga dikunci agar detail booking tetap akurat.
            Mengubah status menjadi dibatalkan tidak otomatis membatalkan booking atau memproses refund.
        </div>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">
            <form action="/bioskop/public/admin/schedules/update?id=<?= (int) $schedule['id'] ?>" method="POST">

                <div class="mb-3">
                    <label for="movie_id" class="form-label">Film</label>
                    <select id="movie_id" name="movie_id" class="form-select"
                            required <?= $scheduleHasBookings ? 'disabled' : '' ?>>
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?= (int) $movie['id'] ?>"
                                <?= (int) $movie['id'] === (int) $schedule['movie_id'] ? 'selected' : '' ?>
                                <?= $movie['status'] === 'ended' && (int) $movie['id'] !== (int) $schedule['movie_id'] ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($movie['title']) ?>
                                (<?= (int) $movie['duration'] ?> menit)
                                - <?= $movie['status'] === 'now_showing' ? 'Sedang Tayang' : ($movie['status'] === 'coming_soon' ? 'Segera Tayang' : 'Selesai') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="studio_id" class="form-label">Studio</label>
                    <select id="studio_id" name="studio_id" class="form-select"
                            required <?= $scheduleHasBookings ? 'disabled' : '' ?>>
                        <?php foreach ($studios as $studio): ?>
                            <option value="<?= (int) $studio['id'] ?>"
                                <?= (int) $studio['id'] === (int) $schedule['studio_id'] ? 'selected' : '' ?>
                                <?= $studio['status'] !== 'active' && (int) $studio['id'] !== (int) $schedule['studio_id'] ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($studio['name']) ?>
                                <?= $studio['status'] === 'active' ? '' : '(Tidak Aktif)' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_at" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" id="start_at" name="start_at"
                               class="form-control"
                               value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($schedule['start_at']))) ?>"
                               required <?= $scheduleHasBookings ? 'readonly' : '' ?>>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_at" class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" id="end_at" name="end_at"
                               class="form-control"
                               value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($schedule['end_at']))) ?>"
                               required <?= $scheduleHasBookings ? 'readonly' : '' ?>>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga Tiket (Rp)</label>
                    <input type="number" id="price" name="price" class="form-control"
                           min="0.01" step="0.01"
                           value="<?= htmlspecialchars($schedule['price']) ?>"
                           required <?= $scheduleHasBookings ? 'readonly' : '' ?>>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status Jadwal</label>
                    <select id="status" name="status" class="form-select" required>
                        <?php foreach ($statusLabels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $schedule['status'] === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                    <a href="/bioskop/public/admin/schedules" class="btn btn-secondary">Kembali</a>
                </div>
            </form>

            <?php if (!$scheduleHasBookings): ?>
                <hr class="border-secondary my-4">
                <form action="/bioskop/public/admin/schedules/delete?id=<?= (int) $schedule['id'] ?>"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus jadwal tayang ini?');">
                    <button type="submit" class="btn btn-outline-danger">Hapus Jadwal</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
