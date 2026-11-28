<?php
/**
 * @var array $studio
 */

$pageTitle = 'Edit Studio';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Edit Studio</h2>
        <p class="text-secondary">
            Ubah informasi studio yang sudah tersimpan.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <form action="/bioskop/public/admin/studios/update?id=<?= $studio['id'] ?>" method="POST">

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Studio</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($studio['name']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">Kapasitas (kursi)</label>
                    <input
                        type="number"
                        id="capacity"
                        name="capacity"
                        class="form-control"
                        value="<?= (int) $studio['capacity'] ?>"
                        min="1"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                    ><?= htmlspecialchars($studio['description'] ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status Studio</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="active" <?= $studio['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= $studio['status'] === 'inactive' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        Simpan Perubahan
                    </button>

                    <a href="/bioskop/public/admin/studios" class="btn btn-secondary">
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
