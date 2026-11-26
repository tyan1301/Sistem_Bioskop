<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function register()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($name === '' || $email === '' || $phone === '' || $password === '') {
                $error = 'Semua kolom wajib diisi.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } elseif (strlen($password) < 8) {
                $error = 'Password minimal 8 karakter.';
            } elseif ($this->user->findByEmail($email)) {
                $error = 'Email sudah terdaftar.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($this->user->create($name, $email, $hashedPassword, $phone)) {
                    $success = 'Registrasi berhasil! Silakan login.';
                } else {
                    $error = 'Registrasi gagal.';
                }
            }
        }

        require __DIR__ . '/../../resources/views/auth/register.php';
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->user->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

            if ($user['role'] === 'admin') {
                header('Location: /bioskop/public/admin');
            } elseif ($user['role'] === 'cashier') {
                header('Location: /bioskop/public/cashier');
            } else {
                header('Location: /bioskop/public/customer');
            }

            exit;

            } else {
                $error = 'Email atau password salah.';
            }
        }

        require __DIR__ . '/../../resources/views/auth/login.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: /bioskop/public/');
        exit;
    }

}
