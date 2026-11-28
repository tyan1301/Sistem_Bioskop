<?php

require_once __DIR__ . '/../Models/Studio.php';

class StudioController
{
    private $studio;

    public function __construct($db)
    {
        $this->studio = new Studio($db);
    }

    public function index()
    {
        $studios = $this->studio->getAll();
        $error = $_GET['error'] ?? '';

        require __DIR__ . '/../../resources/views/admin/studios/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../../resources/views/admin/studios/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/studios');
            exit;
        }

        $this->studio->create($this->getSubmittedData());

        header('Location: /bioskop/public/admin/studios');
        exit;
    }

    public function edit($id)
    {
        $studio = $this->studio->getById($id);

        if (!$studio) {
            http_response_code(404);
            die('Studio tidak ditemukan.');
        }

        require __DIR__ . '/../../resources/views/admin/studios/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/studios');
            exit;
        }

        $this->studio->update($id, $this->getSubmittedData());

        header('Location: /bioskop/public/admin/studios');
        exit;
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/studios');
            exit;
        }

        if ($this->studio->hasRelatedRecords($id)) {
            header('Location: /bioskop/public/admin/studios?error=related');
            exit;
        }

        $this->studio->delete($id);

        header('Location: /bioskop/public/admin/studios');
        exit;
    }

    private function getSubmittedData()
    {
        $name = trim($_POST['name'] ?? '');
        $capacity = filter_var($_POST['capacity'] ?? null, FILTER_VALIDATE_INT);
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? '';

        if ($name === '') {
            die('Nama studio wajib diisi.');
        }

        if ($capacity === false || $capacity < 1) {
            die('Kapasitas studio harus berupa angka minimal 1.');
        }

        if (!in_array($status, ['active', 'inactive'], true)) {
            die('Status studio tidak valid.');
        }

        return [
            'name' => $name,
            'capacity' => $capacity,
            'description' => $description === '' ? null : $description,
            'status' => $status
        ];
    }
}
