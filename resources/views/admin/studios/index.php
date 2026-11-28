<?php
$pageTitle = 'Manajemen Studio';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Studio</h2>
            <p class="text-secondary">
                Kelola daftar studio dan kapasitas kursi bioskop.
            </p>
        </div>

        <a href="/bioskop/public/admin/studios/create" class="btn btn-danger">
            + Tambah Studio
        </a>
    </div>

    <?php if (($error ?? '') === 'related'): ?>
        <div class="alert alert-danger" role="alert">
            Studio tidak dapat dihapus karena masih digunakan oleh data kursi atau jadwal tayang.
        </div>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Studio</th>
                            <th>Kapasitas</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($studios)): ?>

                            <?php foreach ($studios as $index => $studio): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($studio['name']) ?></td>
                                    <td><?= (int) $studio['capacity'] ?> kursi</td>
                                    <td><?= htmlspecialchars($studio['description'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($studio['status'] === 'active'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/bioskop/public/admin/studios/edit?id=<?= $studio['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="/bioskop/public/admin/studios/delete?id=<?= $studio['id'] ?>"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus studio ini?');">

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6" class="text-center text-secondary">
                                    Belum ada data studio.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../layouts/admin_footer.php';
?>
