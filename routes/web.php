
<?php

$baseUrl = '/bioskop/public';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/MovieController.php';
require_once __DIR__ . '/../app/Controllers/GenreController.php';
require_once __DIR__ . '/../app/Controllers/StudioController.php';
require_once __DIR__ . '/../app/Controllers/SeatController.php';
require_once __DIR__ . '/../app/Controllers/ScheduleController.php';

$authController = new AuthController($pdo);
$dashboardController = new DashboardController($pdo);
$movieController = new MovieController($pdo);
$genreController = new GenreController($pdo);
$studioController = new StudioController($pdo);
$seatController = new SeatController($pdo);
$scheduleController = new ScheduleController($pdo);

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

    // MANAJEMEN STUDIO
    '/admin/studios' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $studioController->index();
    },

    '/admin/studios/create' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $studioController->create();
    },

    '/admin/studios/store' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $studioController->store();
    },

    '/admin/studios/edit' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $studioController->edit($id);
    },

    '/admin/studios/update' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $studioController->update($id);
    },

    '/admin/studios/delete' => function () use ($studioController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $studioController->delete($id);
    },

    // MANAJEMEN KURSI
    '/admin/seats' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $seatController->index();
    },

    '/admin/seats/create' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $seatController->create();
    },

    '/admin/seats/store' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $seatController->store();
    },

    '/admin/seats/generate' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $seatController->generate();
    },

    '/admin/seats/edit' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $seatController->edit($id);
    },

    '/admin/seats/update' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $seatController->update($id);
    },

    '/admin/seats/delete' => function () use ($seatController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $seatController->delete($id);
    },

    // MANAJEMEN JADWAL TAYANG
    '/admin/schedules' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $scheduleController->index();
    },

    '/admin/schedules/create' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $scheduleController->create();
    },

    '/admin/schedules/store' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $scheduleController->store();
    },

    '/admin/schedules/edit' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $scheduleController->edit($id);
    },

    '/admin/schedules/update' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $scheduleController->update($id);
    },

    '/admin/schedules/delete' => function () use ($scheduleController, $baseUrl) {
        checkAdmin($baseUrl);
        $id = (int) ($_GET['id'] ?? 0);
        $scheduleController->delete($id);
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