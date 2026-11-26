
<?php
$pageTitle = 'Tambah Film';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Tambah Film</h2>
        <p class="text-secondary">
            Masukkan informasi film yang akan ditampilkan di bioskop.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <form action="/bioskop/public/admin/movies/store" method="POST">

                <div class="mb-3">
                    <label class="form-label">Judul Film</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="synopsis" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="duration" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sutradara</label>
                    <input type="text" name="director" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pemeran</label>
                    <input type="text" name="cast" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating Usia</label>
                    <select name="age_rating" class="form-select" required>
                        <option value="">Pilih Rating</option>
                        <option value="SU">SU - Semua Umur</option>
                        <option value="13+">13+</option>
                        <option value="17+">17+</option>
                        <option value="21+">21+</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Rilis</label>
                    <input type="date" name="release_date" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Status Film</label>
                    <select name="status" class="form-select" required>
                        <option value="">Pilih Status</option>
                        <option value="coming_soon">Coming Soon</option>
                        <option value="now_showing">Now Showing</option>
                        <option value="ended">Ended</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        Simpan Film
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
