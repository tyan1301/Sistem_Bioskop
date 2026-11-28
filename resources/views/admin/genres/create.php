
<?php
require __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="admin-content">

    <div class="page-header">
        <h2>Tambah Genre</h2>
        <p>Tambahkan genre film baru ke dalam sistem.</p>
    </div>

    <div class="content-card">

        <form action="/Sistem_Bioskop/public/admin/genres/store"
              method="POST">

            <div class="form-group">
                <label for="name">Nama Genre</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    placeholder="Contoh: Action, Comedy, Horror"
                    required
                >
            </div>

            <div class="form-actions">

                <a href="/Sistem_Bioskop/public/admin/genres"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Genre
                </button>

            </div>

        </form>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/admin_footer.php'; ?>
