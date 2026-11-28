<?php
$pageTitle = 'Tambah Studio';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Tambah Studio</h2>
        <p class="text-secondary">
            Tambahkan studio baru beserta kapasitas dan statusnya.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <form action="/bioskop/public/admin/studios/store" method="POST">

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Studio</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Contoh: Studio 1"
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
                        placeholder="Contoh: 120"
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
                        placeholder="Masukkan deskripsi studio"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status Studio</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">Pilih Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        Simpan Studio
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
