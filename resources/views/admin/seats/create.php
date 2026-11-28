<?php
$pageTitle = 'Tambah Kursi';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Tambah Kursi</h2>
        <p class="text-secondary">
            Buat tata letak awal sekaligus atau tambahkan satu kursi ke studio yang sudah ada.
        </p>
    </div>

    <?php if (empty($studios)): ?>
        <div class="alert alert-warning" role="alert">
            Buat studio terlebih dahulu sebelum menambahkan kursi.
        </div>
        <a href="/bioskop/public/admin/studios/create" class="btn btn-danger">Tambah Studio</a>
    <?php else: ?>

        <?php if (!$selectedStudio): ?>
            <div class="alert alert-info" role="status">Pilih studio sebelum mengatur kursi.</div>
        <?php else: ?>
            <div class="alert alert-info" role="status">
                Studio <strong><?= htmlspecialchars($selectedStudio['name']) ?></strong>
                memiliki kapasitas <?= (int) $selectedStudio['capacity'] ?> kursi.
                Tata letak awal tidak dapat melebihi kapasitas ini.
            </div>

            <?php if ($existingSeatCount > 0): ?>
                <div class="alert alert-secondary" role="status">
                    Studio ini sudah memiliki <?= $existingSeatCount ?> kursi. Tata letak awal hanya tersedia sebelum kursi pertama ditambahkan; kursi berikutnya dapat ditambahkan satu per satu.
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <?php if ($existingSeatCount === 0): ?>
                    <div class="col-lg-7">
                        <div class="card bg-dark text-white border-secondary h-100">
                            <div class="card-body">
                                <h4 class="h5">Buat Tata Letak Awal</h4>
                                <p class="text-secondary">
                                    Sistem membuat baris A, B, C, dan seterusnya dengan nomor kursi mulai dari 1.
                                    Setelah dibuat, Anda dapat mengatur kursi tertentu secara terpisah.
                                </p>

                                <form action="/bioskop/public/admin/seats/generate" method="POST">
                                    <input type="hidden" name="studio_id" value="<?= (int) $selectedStudio['id'] ?>">

                                    <div class="mb-3">
                                        <label for="row_count" class="form-label">Jumlah Baris</label>
                                        <input type="number" id="row_count" name="row_count"
                                               class="form-control" min="1" max="26" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="seats_per_row" class="form-label">Kursi per Baris</label>
                                        <input type="number" id="seats_per_row" name="seats_per_row"
                                               class="form-control" min="1"
                                               max="<?= (int) $selectedStudio['capacity'] ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="layout_seat_type" class="form-label">Tipe Awal Kursi</label>
                                        <select id="layout_seat_type" name="seat_type" class="form-select" required>
                                            <option value="standard">Standard</option>
                                            <option value="premium">Premium</option>
                                        </select>
                                        <div class="form-text text-secondary">
                                            Tipe kursi dapat diubah satu per satu setelah tata letak dibuat.
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Buat tata letak kursi untuk studio ini?')">
                                        Buat Tata Letak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="<?= $existingSeatCount === 0 ? 'col-lg-5' : 'col-lg-7' ?>">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <h4 class="h5">Tambah Satu Kursi</h4>
                            <p class="text-secondary">
                                Gunakan form ini untuk melengkapi kursi yang kurang atau menambahkan kursi khusus.
                            </p>

                            <form action="/bioskop/public/admin/seats/store" method="POST">
                                <input type="hidden" name="studio_id" value="<?= (int) $selectedStudio['id'] ?>">

                                <div class="mb-3">
                                    <label for="row_label" class="form-label">Label Baris</label>
                                    <input type="text" id="row_label" name="row_label"
                                           class="form-control" maxlength="5"
                                           placeholder="Contoh: A atau VIP" required>
                                </div>

                                <div class="mb-3">
                                    <label for="seat_number" class="form-label">Nomor Kursi</label>
                                    <input type="number" id="seat_number" name="seat_number"
                                           class="form-control" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="seat_type" class="form-label">Tipe Kursi</label>
                                    <select id="seat_type" name="seat_type" class="form-select" required>
                                        <option value="standard">Standard</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select id="is_active" name="is_active" class="form-select" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-outline-light">Simpan Kursi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/bioskop/public/admin/seats<?= $selectedStudio ? '?studio_id=' . (int) $selectedStudio['id'] : '' ?>"
           class="btn btn-secondary">
            Kembali
        </a>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
