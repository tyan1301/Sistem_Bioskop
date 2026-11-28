<?php
$pageTitle = 'Tambah Jadwal Tayang';

require_once __DIR__ . '/../../layouts/admin_header.php';

$availableMovies = array_filter($movies, function ($movie) {
    return $movie['status'] !== 'ended';
});
$availableStudios = array_filter($studios, function ($studio) {
    return $studio['status'] === 'active';
});
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Tambah Jadwal Tayang</h2>
        <p class="text-secondary">
            Pilih film dan studio, lalu masukkan waktu serta harga tiket.
        </p>
    </div>

    <?php if (empty($availableMovies) || empty($availableStudios)): ?>
        <div class="alert alert-warning" role="alert">
            <?php if (empty($availableMovies) && empty($availableStudios)): ?>
                Belum ada film yang dapat dijadwalkan atau studio aktif.
            <?php elseif (empty($availableMovies)): ?>
                Belum ada film yang dapat dijadwalkan. Film berstatus selesai tidak dapat digunakan untuk jadwal baru.
            <?php else: ?>
                Belum ada studio aktif untuk jadwal baru.
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <?php if (empty($availableMovies)): ?>
                <a href="/bioskop/public/admin/movies" class="btn btn-secondary">Kelola Film</a>
            <?php endif; ?>
            <?php if (empty($availableStudios)): ?>
                <a href="/bioskop/public/admin/studios" class="btn btn-secondary">Kelola Studio</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <form action="/bioskop/public/admin/schedules/store" method="POST">

                    <div class="mb-3">
                        <label for="movie_id" class="form-label">Film</label>
                        <select id="movie_id" name="movie_id" class="form-select" required>
                            <option value="">Pilih Film</option>
                            <?php foreach ($availableMovies as $movie): ?>
                                <option value="<?= (int) $movie['id'] ?>">
                                    <?= htmlspecialchars($movie['title']) ?>
                                    (<?= (int) $movie['duration'] ?> menit)
                                    - <?= $movie['status'] === 'now_showing' ? 'Sedang Tayang' : 'Segera Tayang' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="studio_id" class="form-label">Studio</label>
                        <select id="studio_id" name="studio_id" class="form-select" required>
                            <option value="">Pilih Studio</option>
                            <?php foreach ($availableStudios as $studio): ?>
                                <option value="<?= (int) $studio['id'] ?>">
                                    <?= htmlspecialchars($studio['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_at" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" id="start_at" name="start_at"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_at" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" id="end_at" name="end_at"
                                   class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="form-label">Harga Tiket (Rp)</label>
                        <input type="number" id="price" name="price" class="form-control"
                               min="0.01" step="0.01" placeholder="Contoh: 35000" required>
                    </div>

                    <input type="hidden" name="status" value="scheduled">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">Simpan Jadwal</button>
                        <a href="/bioskop/public/admin/schedules" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (empty($availableMovies) || empty($availableStudios)): ?>
        <div class="mt-4">
            <a href="/bioskop/public/admin/schedules" class="btn btn-secondary">Kembali</a>
        </div>
    <?php endif; ?>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
