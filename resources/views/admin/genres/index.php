<?php
/**
 * @var array $genres
 */

require __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="admin-content">

    <div class="page-header">
        <h2>Manajemen Genre</h2>
        <p>Kelola daftar genre film yang tersedia di bioskop.</p>
    </div>

    <div class="content-card">

        <div class="content-header">
            <h3>Daftar Genre</h3>

            <a href="/Sistem_Bioskop/public/admin/genres/create"
               class="btn btn-primary">
                + Tambah Genre
            </a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Genre</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($genres)): ?>

                    <tr>
                        <td colspan="3" class="text-center">
                            Belum ada data genre.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php $no = 1; ?>

                    <?php foreach ($genres as $genre): ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <?= htmlspecialchars($genre['name']) ?>
                            </td>

                            <td>
                                <a href="/Sistem_Bioskop/public/admin/genres/edit?id=<?= $genre['id'] ?>"
                                   class="btn btn-warning">
                                    Edit
                                </a>

                                <form action="/Sistem_Bioskop/public/admin/genres/delete?id=<?= $genre['id'] ?>"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus genre ini?')">

                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>

                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/admin_footer.php'; ?>
