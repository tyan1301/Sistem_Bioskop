
<?php
$pageTitle = 'Manajemen Film';

require_once __DIR__ . '/../../layouts/admin_header.php';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Film</h2>
            <p class="text-secondary">
                Kelola daftar film yang tersedia di bioskop.
            </p>
        </div>

        <a href="/bioskop/public/admin/movies/create" class="btn btn-danger">
            + Tambah Film
        </a>
    </div>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Film</th>
                            <th>Durasi</th>
                            <th>Rating Usia</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                <tbody>
                    <?php if (!empty($movies)): ?>

                        <?php foreach ($movies as $index => $movie): ?>

                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <?= htmlspecialchars($movie['title']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($movie['duration']) ?> menit
                                </td>

                                <td>
                                    <?= htmlspecialchars($movie['age_rating']) ?>
                                </td>

                                <td>
                                    <?php if ($movie['status'] === 'now_showing'): ?>
                                        <span class="badge bg-success">Now Showing</span>

                                    <?php elseif ($movie['status'] === 'coming_soon'): ?>
                                        <span class="badge bg-warning text-dark">Coming Soon</span>

                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ended</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="/bioskop/public/admin/movies/edit?id=<?= $movie['id'] ?>"
                                    class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="/bioskop/public/admin/movies/delete?id=<?= $movie['id'] ?>"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus film ini?');">

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
                                Belum ada data film.
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
