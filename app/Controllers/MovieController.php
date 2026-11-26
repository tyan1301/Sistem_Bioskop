
<?php

require_once __DIR__ . '/../Models/Movie.php';

class MovieController
{
    private $movie;

    public function __construct($db)
    {
        $this->movie = new Movie($db);
    }

    // Menampilkan daftar film
    public function index()
    {
        $movies = $this->movie->getAll();

        require __DIR__ . '/../../resources/views/admin/movies/index.php';
    }

    // Menampilkan form tambah film
    public function create()
    {
        require __DIR__ . '/../../resources/views/admin/movies/create.php';
    }

    // Menyimpan film baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/movies');
            exit;
        }

        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'synopsis' => trim($_POST['synopsis'] ?? ''),
            'duration' => (int) ($_POST['duration'] ?? 0),
            'director' => trim($_POST['director'] ?? ''),
            'cast' => trim($_POST['cast'] ?? ''),
            'age_rating' => $_POST['age_rating'] ?? '',
            'release_date' => $_POST['release_date'] ?? '',
            'status' => $_POST['status'] ?? ''
        ];

        if (
            $data['title'] === '' ||
            $data['duration'] <= 0 ||
            $data['age_rating'] === '' ||
            $data['release_date'] === '' ||
            $data['status'] === ''
        ) {
            die('Mohon lengkapi data film yang wajib diisi.');
        }

        $this->movie->create($data);

        header('Location: /bioskop/public/admin/movies');
        exit;
    }


    // Menampilkan form edit film
    public function edit($id)
    {
        $movie = $this->movie->getById($id);

        if (!$movie) {
            die('Film tidak ditemukan.');
        }

        require __DIR__ . '/../../resources/views/admin/movies/edit.php';
    }

    // Memproses perubahan data film
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/movies');
            exit;
        }

        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'synopsis' => trim($_POST['synopsis'] ?? ''),
            'duration' => (int) ($_POST['duration'] ?? 0),
            'director' => trim($_POST['director'] ?? ''),
            'cast' => trim($_POST['cast'] ?? ''),
            'age_rating' => $_POST['age_rating'] ?? '',
            'release_date' => $_POST['release_date'] ?? '',
            'status' => $_POST['status'] ?? ''
        ];

        if (
            $data['title'] === '' ||
            $data['duration'] <= 0 ||
            $data['age_rating'] === '' ||
            $data['release_date'] === '' ||
            $data['status'] === ''
        ) {
            die('Mohon lengkapi data film yang wajib diisi.');
        }

        $this->movie->update($id, $data);

        header('Location: /bioskop/public/admin/movies');
        exit;
    }

    // Memproses penghapusan film
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/movies');
            exit;
        }

        $this->movie->delete($id);

        header('Location: /bioskop/public/admin/movies');
        exit;
    }


}
