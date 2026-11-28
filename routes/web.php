
<?php

$baseUrl = '/bioskop/public';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/MovieController.php';
require_once __DIR__ . '/../app/Controllers/GenreController.php';

$authController = new AuthController($pdo);
$dashboardController = new DashboardController($pdo);
$movieController = new MovieController($pdo);
$genreController = new GenreController($pdo);

// Memeriksa apakah pengguna adalah admin
function checkAdmin($baseUrl)
{
    if (
        !isset($_SESSION['user']) ||
        $_SESSION['user']['role'] !== 'admin'
    ) {
        header("Location: $baseUrl/login");
        exit;
    }
}

$routes = [

    '/' => function () {
        require __DIR__ . '/../resources/views/home.php';
    },

    // AUTH
    '/login' => function () use ($authController) {
        $authController->login();
    },

    '/register' => function () use ($authController) {
        $authController->register();
    },

    '/logout' => function () use ($authController) {
        $authController->logout();
    },

    // DASHBOARD ADMIN
    '/admin' => function () use ($dashboardController, $baseUrl) {
        checkAdmin($baseUrl);
        $dashboardController->index();
    },

    // MANAJEMEN FILM
    '/admin/movies' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $movieController->index();
    },

    '/admin/movies/create' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $movieController->create();
    },

    '/admin/movies/store' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $movieController->store();
    },

    '/admin/movies/edit' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $movieController->edit($id);
    },

    '/admin/movies/update' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $movieController->update($id);
    },

    '/admin/movies/delete' => function () use ($movieController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $movieController->delete($id);
    },

    // MANAJEMEN GENRE
    '/admin/genres' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $genreController->index();
    },

    '/admin/genres/create' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $genreController->create();
    },

    '/admin/genres/store' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $genreController->store();
    },

    '/admin/genres/edit' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $genreController->edit($id);
    },

    '/admin/genres/update' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $genreController->update($id);
    },

    '/admin/genres/delete' => function () use ($genreController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $genreController->delete($id);
    },

    // DASHBOARD KASIR
    '/cashier' => function () use ($baseUrl) {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'cashier'
        ) {
            header("Location: $baseUrl/login");
            exit;
        }

        require __DIR__ . '/../resources/views/kasir/dashboard.php';
    },

    // DASHBOARD CUSTOMER
    '/customer' => function () use ($baseUrl) {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'customer'
        ) {
            header("Location: $baseUrl/login");
            exit;
        }

        require __DIR__ . '/../resources/views/customer/dashboard.php';
    },

];

// Membaca URL yang dibuka
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace($baseUrl, '', $uri);

if ($uri === '') {
    $uri = '/';
}

// Menjalankan route
if (isset($routes[$uri])) {
    $routes[$uri]();
} else {
    http_response_code(404);
    echo 'Halaman tidak ditemukan!';
}