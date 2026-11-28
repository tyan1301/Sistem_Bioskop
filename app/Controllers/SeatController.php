<?php

require_once __DIR__ . '/../Models/Seat.php';
require_once __DIR__ . '/../Models/Studio.php';

class SeatController
{
    private $seat;
    private $studio;

    public function __construct($db)
    {
        $this->seat = new Seat($db);
        $this->studio = new Studio($db);
    }

    public function index()
    {
        $studios = $this->studio->getAll();
        $studioId = (int) ($_GET['studio_id'] ?? 0);

        if ($studioId === 0 && count($studios) === 1) {
            $studioId = (int) $studios[0]['id'];
        }

        $selectedStudio = $studioId > 0 ? $this->studio->getById($studioId) : false;
        $seats = $selectedStudio ? $this->seat->getByStudio($studioId) : [];
        $seatsByRow = [];

        foreach ($seats as $seat) {
            $seatsByRow[$seat['row_label']][] = $seat;
        }

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        require __DIR__ . '/../../resources/views/admin/seats/index.php';
    }

    public function create()
    {
        $studios = $this->studio->getAll();
        $studioId = (int) ($_GET['studio_id'] ?? 0);
        $selectedStudio = $studioId > 0 ? $this->studio->getById($studioId) : false;
        $existingSeatCount = $selectedStudio ? $this->seat->countByStudio($studioId) : 0;

        require __DIR__ . '/../../resources/views/admin/seats/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/seats');
            exit;
        }

        $data = $this->getSubmittedSeatData();

        $studio = $this->studio->getById($data['studio_id']);

        if (!$studio) {
            header('Location: /bioskop/public/admin/seats?error=studio');
            exit;
        }

        if ($this->seat->countByStudio($data['studio_id']) >= (int) $studio['capacity']) {
            header('Location: /bioskop/public/admin/seats?studio_id=' . $data['studio_id'] . '&error=capacity');
            exit;
        }

        if ($this->seat->positionExists($data['studio_id'], $data['row_label'], $data['seat_number'])) {
            header('Location: /bioskop/public/admin/seats?studio_id=' . $data['studio_id'] . '&error=duplicate');
            exit;
        }

        $this->seat->create($data);

        header('Location: /bioskop/public/admin/seats?studio_id=' . $data['studio_id'] . '&success=saved');
        exit;
    }

    public function edit($id)
    {
        $seat = $this->seat->getById($id);

        if (!$seat) {
            http_response_code(404);
            die('Kursi tidak ditemukan.');
        }

        $seatHasBookings = $this->seat->hasBookings($id);

        require __DIR__ . '/../../resources/views/admin/seats/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/seats');
            exit;
        }

        $seat = $this->seat->getById($id);

        if (!$seat) {
            http_response_code(404);
            die('Kursi tidak ditemukan.');
        }

        if ($this->seat->hasBookings($id)) {
            $isActive = $_POST['is_active'] ?? '';

            if (!in_array($isActive, ['0', '1'], true)) {
                die('Status kursi tidak valid.');
            }

            $data = [
                'row_label' => $seat['row_label'],
                'seat_number' => $seat['seat_number'],
                'seat_type' => $seat['seat_type'],
                'is_active' => (int) $isActive
            ];
        } else {
            $data = $this->getSubmittedSeatData($seat['studio_id']);

            if ($this->seat->positionExists($seat['studio_id'], $data['row_label'], $data['seat_number'], $id)) {
                header('Location: /bioskop/public/admin/seats?studio_id=' . $seat['studio_id'] . '&error=duplicate');
                exit;
            }
        }

        $this->seat->update($id, $data);

        header('Location: /bioskop/public/admin/seats?studio_id=' . $seat['studio_id'] . '&success=saved');
        exit;
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/seats');
            exit;
        }

        $seat = $this->seat->getById($id);

        if (!$seat) {
            header('Location: /bioskop/public/admin/seats?error=missing');
            exit;
        }

        if ($this->seat->hasBookings($id)) {
            header('Location: /bioskop/public/admin/seats?studio_id=' . $seat['studio_id'] . '&error=related');
            exit;
        }

        $this->seat->delete($id);

        header('Location: /bioskop/public/admin/seats?studio_id=' . $seat['studio_id'] . '&success=deleted');
        exit;
    }

    public function generate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /bioskop/public/admin/seats');
            exit;
        }

        $studioId = filter_var($_POST['studio_id'] ?? null, FILTER_VALIDATE_INT);
        $rowCount = filter_var($_POST['row_count'] ?? null, FILTER_VALIDATE_INT);
        $seatsPerRow = filter_var($_POST['seats_per_row'] ?? null, FILTER_VALIDATE_INT);
        $seatType = $_POST['seat_type'] ?? '';
        $studio = $studioId ? $this->studio->getById($studioId) : false;

        if (
            !$studio ||
            $rowCount === false || $rowCount < 1 || $rowCount > 26 ||
            $seatsPerRow === false || $seatsPerRow < 1 ||
            !in_array($seatType, ['standard', 'premium'], true)
        ) {
            header('Location: /bioskop/public/admin/seats?error=invalid');
            exit;
        }

        if ($rowCount * $seatsPerRow > (int) $studio['capacity']) {
            header('Location: /bioskop/public/admin/seats?studio_id=' . $studioId . '&error=capacity');
            exit;
        }

        if (!$this->seat->generateLayout($studioId, $rowCount, $seatsPerRow, $seatType)) {
            header('Location: /bioskop/public/admin/seats?studio_id=' . $studioId . '&error=layout_exists');
            exit;
        }

        header('Location: /bioskop/public/admin/seats?studio_id=' . $studioId . '&success=generated');
        exit;
    }

    private function getSubmittedSeatData($studioId = null)
    {
        if ($studioId === null) {
            $studioId = filter_var($_POST['studio_id'] ?? null, FILTER_VALIDATE_INT);
        }

        $rowLabel = strtoupper(trim($_POST['row_label'] ?? ''));
        $seatNumber = filter_var($_POST['seat_number'] ?? null, FILTER_VALIDATE_INT);
        $seatType = $_POST['seat_type'] ?? '';
        $isActive = $_POST['is_active'] ?? '';

        if (!$studioId || !preg_match('/^[A-Z0-9]{1,5}$/', $rowLabel)) {
            die('Studio dan label baris kursi tidak valid.');
        }

        if ($seatNumber === false || $seatNumber < 1) {
            die('Nomor kursi harus berupa angka minimal 1.');
        }

        if (!in_array($seatType, ['standard', 'premium'], true)) {
            die('Tipe kursi tidak valid.');
        }

        if (!in_array($isActive, ['0', '1'], true)) {
            die('Status kursi tidak valid.');
        }

        return [
            'studio_id' => $studioId,
            'row_label' => $rowLabel,
            'seat_number' => $seatNumber,
            'seat_type' => $seatType,
            'is_active' => (int) $isActive
        ];
    }
}
