<?php
/**
 * @var array $seat
 */

$pageTitle = 'Edit Kursi';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Edit Kursi <?= htmlspecialchars($seat['row_label']) ?><?= (int) $seat['seat_number'] ?></h2>
        <p class="text-secondary">
            Ubah posisi, tipe, atau status kursi. Kursi nonaktif tidak ditawarkan untuk pemesanan baru.
        </p>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <?php if ($seatHasBookings): ?>
                <div class="alert alert-info" role="status">
                    Kursi ini sudah tercatat pada booking. Posisi dan tipenya dikunci agar data booking lama tetap akurat; status aktif masih dapat diubah.
                </div>
            <?php endif; ?>

            <form action="/bioskop/public/admin/seats/update?id=<?= (int) $seat['id'] ?>" method="POST">
                <input type="hidden" name="studio_id" value="<?= (int) $seat['studio_id'] ?>">

                <div class="mb-3">
                    <label for="row_label" class="form-label">Label Baris</label>
                    <input type="text" id="row_label" name="row_label"
                           class="form-control" maxlength="5"
                           value="<?= htmlspecialchars($seat['row_label']) ?>" required
                           <?= $seatHasBookings ? 'readonly' : '' ?>>
                </div>

                <div class="mb-3">
                    <label for="seat_number" class="form-label">Nomor Kursi</label>
                    <input type="number" id="seat_number" name="seat_number"
                           class="form-control" min="1"
                           value="<?= (int) $seat['seat_number'] ?>" required
                           <?= $seatHasBookings ? 'readonly' : '' ?>>
                </div>

                <div class="mb-3">
                    <label for="seat_type" class="form-label">Tipe Kursi</label>
                    <select id="seat_type" name="seat_type" class="form-select" required
                            <?= $seatHasBookings ? 'disabled' : '' ?>>
                        <option value="standard" <?= $seat['seat_type'] === 'standard' ? 'selected' : '' ?>>Standard</option>
                        <option value="premium" <?= $seat['seat_type'] === 'premium' ? 'selected' : '' ?>>Premium</option>
                    </select>
                    <?php if ($seatHasBookings): ?>
                        <input type="hidden" name="seat_type" value="<?= htmlspecialchars($seat['seat_type']) ?>">
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="is_active" class="form-label">Status</label>
                    <select id="is_active" name="is_active" class="form-select" required>
                        <option value="1" <?= (int) $seat['is_active'] === 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= (int) $seat['is_active'] === 0 ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                    <a href="/bioskop/public/admin/seats?studio_id=<?= (int) $seat['studio_id'] ?>"
                       class="btn btn-secondary">Kembali</a>
                </div>
            </form>

            <hr class="border-secondary my-4">

            <form action="/bioskop/public/admin/seats/delete?id=<?= (int) $seat['id'] ?>"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus kursi ini?');">
                <button type="submit" class="btn btn-outline-danger">Hapus Kursi</button>
                <span class="text-secondary ms-2">
                    Kursi yang sudah tercatat pada booking tidak dapat dihapus.
                </span>
            </form>

        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
