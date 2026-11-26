<?php

require_once __DIR__ . '/../app/Controllers/AuthController.php';

$authController = new AuthController($pdo);

require_once __DIR__ . '/../app/Controllers/DashboardController.php';

$dashboardController = new DashboardController($pdo);

require_once __DIR__ . '/../app/Controllers/MovieController.php';

$movieController = new MovieController($pdo);

$routes = [
    '/' => function () {
        require __DIR__ . '/../resources/views/home.php';
    },

    '/login' => function () use ($authController) {
        $authController->login();
    },

    '/register' => function () use ($authController) {
        $authController->register();
    },

    '/logout' => function () use ($authController) {
        $authController->logout();
    },

    '/admin' => function () use ($dashboardController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $dashboardController->index();
    },

    '/cashier' => function () {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cashier') {
            header('Location: /bioskop/public/login');
            exit;
        }

        require __DIR__ . '/../resources/views/kasir/dashboard.php';
    },

    '/customer' => function () {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
            header('Location: /bioskop/public/login');
            exit;
        }

        require __DIR__ . '/../resources/views/customer/dashboard.php';
    },

    '/admin/movies' => function () {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        require __DIR__ . '/../resources/views/admin/movies/index.php';
    },

        // Halaman daftar film
    '/admin/movies' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $movieController->index();
    },

    // Form tambah film
    '/admin/movies/create' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $movieController->create();
    },

    // Proses menyimpan film
    '/admin/movies/store' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $movieController->store();
    },

    // Halaman edit film
    '/admin/movies/edit' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $id = (int) ($_GET['id'] ?? 0);

        $movieController->edit($id);
    },

    // Proses update film
    '/admin/movies/update' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $id = (int) ($_GET['id'] ?? 0);

        $movieController->update($id);
    },

    // Proses hapus film
    '/admin/movies/delete' => function () use ($movieController) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /bioskop/public/login');
            exit;
        }

        $id = (int) ($_GET['id'] ?? 0);

        $movieController->delete($id);
    },

];

$basePath = '/bioskop/public';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($basePath, '', $uri);

if ($uri === '') {
    $uri = '/';
}

if (isset($routes[$uri])) {
    $routes[$uri]();
} else {
    http_response_code(404);
    echo 'Halaman tidak ditemukan!';
}
