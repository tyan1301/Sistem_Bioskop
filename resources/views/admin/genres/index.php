<?php
$pageTitle = 'Manajemen Genre';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Genre</h2>
            <p class="text-secondary">
                Kelola daftar genre film yang tersedia di bioskop.
            </p>
        </div>

        <a href="/bioskop/public/admin/genres/create" class="btn btn-danger">
            + Tambah Genre
        </a>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Genre</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($genres)): ?>

                            <?php foreach ($genres as $index => $genre): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <?= htmlspecialchars($genre['name']) ?>
                                    </td>

                                    <td>
                                        <a href="/bioskop/public/admin/genres/edit?id=<?= $genre['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="/bioskop/public/admin/genres/delete?id=<?= $genre['id'] ?>"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus genre ini?');">

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="3" class="text-center text-secondary">
                                    Belum ada data genre.
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
