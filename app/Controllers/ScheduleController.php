<?php

require_once __DIR__ . '/../Models/Schedule.php';
require_once __DIR__ . '/../Models/Movie.php';
require_once __DIR__ . '/../Models/Studio.php';

class ScheduleController
{
    private $schedule;
    private $movie;
    private $studio;

    public function __construct($db)
    {
        $this->schedule = new Schedule($db);
        $this->movie = new Movie($db);
        $this->studio = new Studio($db);
    }

    public function index()
    {
        $dateInput = $_GET['date'] ?? '';
        $date = is_string($dateInput) ? trim($dateInput) : '';
        $status = $_GET['status'] ?? '';
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        if ($dateInput !== '' && (!is_string($dateInput) || !$this->isValidDate($date))) {
            $date = '';
            $error = 'filter';
        }

        if (!is_string($status) || ($status !== '' && !in_array($status, ['scheduled', 'cancelled', 'completed'], true))) {
            $status = '';
            $error = 'filter';
        }

        $schedules = $this->schedule->getAll($date, $status);

        require __DIR__ . '/../../resources/views/admin/schedules/index.php';
    }

    public function create()
    {
        $movies = $this->movie->getAll();
        $studios = $this->studio->getAll();

        require __DIR__ . '/../../resources/views/admin/schedules/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/schedules');
            exit;
        }

        $data = $this->getSubmittedData(['scheduled']);
        $this->validateReferencesAndDuration($data);

        if ($this->schedule->hasConflict($data['studio_id'], $data['start_at'], $data['end_at'])) {
            header('Location: /bioskop/public/admin/schedules?error=conflict');
            exit;
        }

        $this->schedule->create($data);

        header('Location: /bioskop/public/admin/schedules?success=created');
        exit;
    }

    public function edit($id)
    {
        $schedule = $this->schedule->getById($id);

        if (!$schedule) {
            http_response_code(404);
            die('Jadwal tayang tidak ditemukan.');
        }

        $movies = $this->movie->getAll();
        $studios = $this->studio->getAll();
        $scheduleHasBookings = $this->schedule->hasBookings($id);

        require __DIR__ . '/../../resources/views/admin/schedules/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/schedules');
            exit;
        }

        $schedule = $this->schedule->getById($id);

        if (!$schedule) {
            http_response_code(404);
            die('Jadwal tayang tidak ditemukan.');
        }

        if ($this->schedule->hasBookings($id)) {
            $status = $_POST['status'] ?? '';

            if (!in_array($status, ['scheduled', 'cancelled', 'completed'], true)) {
                die('Status jadwal tidak valid.');
            }

            $data = [
                'movie_id' => (int) $schedule['movie_id'],
                'studio_id' => (int) $schedule['studio_id'],
                'start_at' => $schedule['start_at'],
                'end_at' => $schedule['end_at'],
                'price' => $schedule['price'],
                'status' => $status
            ];
        } else {
            $data = $this->getSubmittedData(['scheduled', 'cancelled', 'completed']);
        }

        $this->validateReferencesAndDuration($data, $schedule);

        if (
            $data['status'] === 'scheduled' &&
            $this->schedule->hasConflict($data['studio_id'], $data['start_at'], $data['end_at'], $id)
        ) {
            header('Location: /bioskop/public/admin/schedules?error=conflict');
            exit;
        }

        $this->schedule->update($id, $data);

        header('Location: /bioskop/public/admin/schedules?success=updated');
        exit;
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/schedules');
            exit;
        }

        if (!$this->schedule->getById($id)) {
            header('Location: /bioskop/public/admin/schedules?error=missing');
            exit;
        }

        if ($this->schedule->hasBookings($id)) {
            header('Location: /bioskop/public/admin/schedules?error=related');
            exit;
        }

        $this->schedule->delete($id);

        header('Location: /bioskop/public/admin/schedules?success=deleted');
        exit;
    }

    private function getSubmittedData($allowedStatuses)
    {
        $movieId = filter_var($_POST['movie_id'] ?? null, FILTER_VALIDATE_INT);
        $studioId = filter_var($_POST['studio_id'] ?? null, FILTER_VALIDATE_INT);
        $startAtInput = $_POST['start_at'] ?? '';
        $endAtInput = $_POST['end_at'] ?? '';
        $startAt = $this->normalizeDateTime($startAtInput);
        $endAt = $this->normalizeDateTime($endAtInput);
        $priceInput = $_POST['price'] ?? '';
        $price = is_string($priceInput) ? trim($priceInput) : '';
        $status = $_POST['status'] ?? '';

        if (!$movieId || !$studioId || $startAt === false || $endAt === false) {
            die('Film, studio, waktu mulai, dan waktu selesai harus diisi dengan benar.');
        }

        if (strtotime($endAt) <= strtotime($startAt)) {
            die('Waktu selesai harus setelah waktu mulai.');
        }

        if (!preg_match('/^\d{1,10}(?:\.\d{1,2})?$/', $price) || (float) $price <= 0) {
            die('Harga tiket harus berupa angka lebih besar dari 0 dengan maksimal 2 angka desimal.');
        }

        if (!in_array($status, $allowedStatuses, true)) {
            die('Status jadwal tidak valid.');
        }

        return [
            'movie_id' => $movieId,
            'studio_id' => $studioId,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'price' => $price,
            'status' => $status
        ];
    }

    private function validateReferencesAndDuration($data, $existingSchedule = null)
    {
        $movie = $this->movie->getById($data['movie_id']);
        $studio = $this->studio->getById($data['studio_id']);

        if (!$movie || !$studio) {
            die('Film atau studio yang dipilih tidak ditemukan.');
        }

        $sameMovie = $existingSchedule && (int) $existingSchedule['movie_id'] === (int) $movie['id'];
        $sameStudio = $existingSchedule && (int) $existingSchedule['studio_id'] === (int) $studio['id'];

        if ($movie['status'] === 'ended' && (!$sameMovie || $data['status'] === 'scheduled')) {
            die('Film yang sudah tidak tayang tidak dapat dijadwalkan kembali.');
        }

        if ($studio['status'] !== 'active' && (!$sameStudio || $data['status'] === 'scheduled')) {
            die('Studio tidak aktif tidak dapat digunakan untuk jadwal baru.');
        }

        if (strtotime($data['end_at']) - strtotime($data['start_at']) < (int) $movie['duration'] * 60) {
            die('Durasi jadwal tidak boleh lebih pendek dari durasi film.');
        }
    }

    private function normalizeDateTime($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $value);
        $errors = DateTime::getLastErrors();

        if (
            !$dateTime ||
            ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))
        ) {
            return false;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }

    private function isValidDate($value)
    {
        $date = DateTime::createFromFormat('!Y-m-d', $value);
        $errors = DateTime::getLastErrors();

        return $date &&
            $date->format('Y-m-d') === $value &&
            ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0));
    }
}
