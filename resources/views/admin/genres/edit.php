
<?php
/**
 * @var array $genre
 */

require __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="admin-content">

    <div class="page-header">
        <h2>Edit Genre</h2>
        <p>Ubah nama genre film yang sudah tersedia.</p>
    </div>

    <div class="content-card">

        <form action="/Sistem_Bioskop/public/admin/genres/update?id=<?= $genre['id'] ?>"
              method="POST">

            <div class="form-group">
                <label for="name">Nama Genre</label>

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

            <div class="form-actions">

                <a href="/Sistem_Bioskop/public/admin/genres"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/admin_footer.php'; ?>
