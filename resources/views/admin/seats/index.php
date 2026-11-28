<?php
$pageTitle = 'Manajemen Kursi';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2>Manajemen Kursi</h2>
        <p class="text-secondary">
            Atur tata letak kursi per studio. Kursi nonaktif tidak ditawarkan untuk pemesanan baru.
        </p>
    </div>

    <?php if ($error === 'related'): ?>
        <div class="alert alert-danger" role="alert">
            Kursi tidak dapat dihapus karena sudah tercatat pada booking. Nonaktifkan kursi agar tidak digunakan untuk pemesanan baru.
        </div>
    <?php elseif ($error === 'capacity'): ?>
        <div class="alert alert-danger" role="alert">
            Jumlah kursi akan melebihi kapasitas studio.
        </div>
    <?php elseif ($error === 'layout_exists'): ?>
        <div class="alert alert-warning" role="alert">
            Studio ini sudah memiliki data kursi. Tambahkan atau ubah kursi dari daftar agar data yang ada tidak tertimpa.
        </div>
    <?php elseif ($error === 'studio'): ?>
        <div class="alert alert-danger" role="alert">
            Studio yang dipilih tidak ditemukan.
        </div>
    <?php elseif ($error === 'invalid'): ?>
        <div class="alert alert-danger" role="alert">
            Data tata letak tidak valid. Periksa kembali studio, jumlah baris, jumlah kursi, dan tipe kursi.
        </div>
    <?php elseif ($error === 'duplicate'): ?>
        <div class="alert alert-warning" role="alert">
            Posisi kursi tersebut sudah digunakan di studio ini.
        </div>
    <?php elseif ($error === 'missing'): ?>
        <div class="alert alert-warning" role="alert">
            Kursi yang diminta tidak ditemukan.
        </div>
    <?php endif; ?>

    <?php if ($success === 'generated'): ?>
        <div class="alert alert-success" role="alert">Tata letak kursi berhasil dibuat.</div>
    <?php elseif ($success === 'saved'): ?>
        <div class="alert alert-success" role="alert">Data kursi berhasil disimpan.</div>
    <?php elseif ($success === 'deleted'): ?>
        <div class="alert alert-success" role="alert">Kursi berhasil dihapus.</div>
    <?php endif; ?>

    <?php if (empty($studios)): ?>
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <p class="mb-3">Belum ada studio. Buat studio terlebih dahulu sebelum mengatur kursinya.</p>
                <a href="/bioskop/public/admin/studios/create" class="btn btn-danger">Tambah Studio</a>
            </div>
        </div>
    <?php else: ?>

        <div class="card bg-dark text-white border-secondary mb-4">
            <div class="card-body">
                <form action="/bioskop/public/admin/seats" method="GET" class="row align-items-end g-3">
                    <div class="col-md-8">
                        <label for="studio_id" class="form-label">Pilih Studio</label>
                        <select id="studio_id" name="studio_id" class="form-select" required>
                            <option value="">Pilih studio</option>
                            <?php foreach ($studios as $studio): ?>
                                <option value="<?= (int) $studio['id'] ?>"
                                    <?= $selectedStudio && (int) $selectedStudio['id'] === (int) $studio['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($studio['name']) ?> (kapasitas <?= (int) $studio['capacity'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-secondary">Tampilkan Kursi</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!$selectedStudio): ?>
            <div class="alert alert-info" role="status">Pilih studio untuk melihat dan mengatur kursinya.</div>
        <?php else: ?>
            <?php
            $activeCount = 0;
            $premiumCount = 0;
            foreach ($seats as $seat) {
                $activeCount += (int) $seat['is_active'] === 1 ? 1 : 0;
                $premiumCount += $seat['seat_type'] === 'premium' ? 1 : 0;
            }
            ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1"><?= htmlspecialchars($selectedStudio['name']) ?></h4>
                    <span class="text-secondary">
                        <?= count($seats) ?> kursi terdaftar / kapasitas <?= (int) $selectedStudio['capacity'] ?>
                    </span>
                </div>
                <?php if (count($seats) < (int) $selectedStudio['capacity']): ?>
                    <a href="/bioskop/public/admin/seats/create?studio_id=<?= (int) $selectedStudio['id'] ?>"
                       class="btn btn-danger">
                        + Tambah Kursi
                    </a>
                <?php else: ?>
                    <span class="badge bg-secondary">Kapasitas telah terpenuhi</span>
                <?php endif; ?>
            </div>

            <?php if (count($seats) !== (int) $selectedStudio['capacity']): ?>
                <div class="alert alert-warning" role="status">
                    Jumlah kursi terdaftar berbeda dari kapasitas studio. Periksa tata letak agar sesuai dengan kondisi sebenarnya.
                </div>
            <?php endif; ?>

            <div class="row g-3 mb-4">
                <div class="col-sm-4">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <div class="text-secondary">Total Kursi</div>
                            <strong class="fs-4"><?= count($seats) ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <div class="text-secondary">Kursi Aktif</div>
                            <strong class="fs-4"><?= $activeCount ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <div class="text-secondary">Kursi Premium</div>
                            <strong class="fs-4"><?= $premiumCount ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($seats)): ?>
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-body">
                        <h5>Belum ada kursi di studio ini</h5>
                        <p class="text-secondary">
                            Buat tata letak awal sekaligus, lalu ubah tipe atau status kursi tertentu dari daftar.
                        </p>
                        <a href="/bioskop/public/admin/seats/create?studio_id=<?= (int) $selectedStudio['id'] ?>"
                           class="btn btn-danger">
                            Buat Tata Letak Kursi
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($seatsByRow as $rowLabel => $rowSeats): ?>
                    <div class="card bg-dark text-white border-secondary mb-3">
                        <div class="card-header">
                            Baris <?= htmlspecialchars($rowLabel) ?>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($rowSeats as $seat): ?>
                                    <a href="/bioskop/public/admin/seats/edit?id=<?= (int) $seat['id'] ?>"
                                       class="btn <?= (int) $seat['is_active'] === 1 ? ($seat['seat_type'] === 'premium' ? 'btn-warning' : 'btn-outline-light') : 'btn-outline-secondary' ?>"
                                       title="<?= (int) $seat['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?> - <?= $seat['seat_type'] === 'premium' ? 'Premium' : 'Standard' ?>">
                                        <?= htmlspecialchars($seat['row_label']) ?><?= (int) $seat['seat_number'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p class="small text-secondary">
                    Klik kursi untuk mengubah tipe, status, atau labelnya. Kuning menandakan premium; abu-abu menandakan nonaktif.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
