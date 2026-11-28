<?php
/**
 * @var array $genre
 */

$pageTitle = 'Edit Genre';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Edit Genre</h2>
        <p class="text-secondary">
            Ubah nama genre film yang sudah tersedia.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <form action="/bioskop/public/admin/genres/update?id=<?= $genre['id'] ?>" method="POST">

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Genre</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($genre['name']) ?>"
                        placeholder="Masukkan nama genre"
                        required
                    >
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        Simpan Perubahan
                    </button>

                    <a href="/bioskop/public/admin/genres" class="btn btn-secondary">
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
