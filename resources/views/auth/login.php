<?php
$pageTitle = 'Login';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card bg-dark text-white border-secondary">
                <div class="card-body p-4">

                    <h2 class="text-center text-red mb-4">
                        Login
                    </h2>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/bioskop/public/login">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-red w-100">
                            Masuk
                        </button>

                    </form>

                    <p class="text-center mt-3 mb-0">
                        Belum punya akun?
                        <a href="/bioskop/public/register" class="text-danger">
                            Daftar
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
