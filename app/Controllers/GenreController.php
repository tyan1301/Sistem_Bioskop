<?php

require_once __DIR__ . '/../Models/Genre.php';

class GenreController
{
    private $genre;

    public function __construct($db)
    {
        $this->genre = new Genre($db);
    }

    // Menampilkan daftar genre
    public function index()
    {
        $genres = $this->genre->getAll();

        require __DIR__ . '/../../resources/views/admin/genres/index.php';
    }

    // Menampilkan form tambah genre
    public function create()
    {
        require __DIR__ . '/../../resources/views/admin/genres/create.php';
    }

    // Menyimpan genre baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Sistem_Bioskop/public/admin/genres');
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            die('Nama genre wajib diisi.');
        }

        $this->genre->create([
            'name' => $name
        ]);

        header('Location: /Sistem_Bioskop/public/admin/genres');
        exit;
    }

    // Menampilkan form edit genre
    public function edit($id)
    {
        $genre = $this->genre->getById($id);

        if (!$genre) {
            die('Genre tidak ditemukan.');
        }

        require __DIR__ . '/../../resources/views/admin/genres/edit.php';
    }

    // Memproses perubahan genre
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Sistem_Bioskop/public/admin/genres');
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            die('Nama genre wajib diisi.');
        }

        $this->genre->update($id, [
            'name' => $name
        ]);

        header('Location: /Sistem_Bioskop/public/admin/genres');
        exit;
    }

    // Menghapus genre
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Sistem_Bioskop/public/admin/genres');
            exit;
        }

        $this->genre->delete($id);

        header('Location: /Sistem_Bioskop/public/admin/genres');
        exit;
    }
}
