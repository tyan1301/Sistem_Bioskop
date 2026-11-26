<?php
/**
 * @var array $movie
 */

$pageTitle = 'Edit Film';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Edit Film</h2>
        <p class="text-secondary">
            Ubah informasi film yang sudah tersimpan.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <form action="/bioskop/public/admin/movies/update?id=<?= $movie['id'] ?>" method="POST">

                <div class="mb-3">
                    <label class="form-label">Judul Film</label>
                    <input type="text" name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['title']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="synopsis"
                        class="form-control"
                        rows="4"><?= htmlspecialchars($movie['synopsis'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="duration"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['duration']) ?>"
                        min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sutradara</label>
                    <input type="text" name="director"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['director'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pemeran</label>
                    <input type="text" name="cast"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['cast'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating Usia</label>
                    <select name="age_rating" class="form-select" required>
                        <option value="SU" <?= $movie['age_rating'] === 'SU' ? 'selected' : '' ?>>SU - Semua Umur</option>
                        <option value="13+" <?= $movie['age_rating'] === '13+' ? 'selected' : '' ?>>13+</option>
                        <option value="17+" <?= $movie['age_rating'] === '17+' ? 'selected' : '' ?>>17+</option>
                        <option value="21+" <?= $movie['age_rating'] === '21+' ? 'selected' : '' ?>>21+</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Rilis</label>
                    <input type="date" name="release_date"
                        class="form-control"
                        value="<?= htmlspecialchars($movie['release_date']) ?>"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Status Film</label>
                    <select name="status" class="form-select" required>
                        <option value="coming_soon" <?= $movie['status'] === 'coming_soon' ? 'selected' : '' ?>>Coming Soon</option>
                        <option value="now_showing" <?= $movie['status'] === 'now_showing' ? 'selected' : '' ?>>Now Showing</option>
                        <option value="ended" <?= $movie['status'] === 'ended' ? 'selected' : '' ?>>Ended</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        Simpan Perubahan
                    </button>

                    <a href="/bioskop/public/admin/movies" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
