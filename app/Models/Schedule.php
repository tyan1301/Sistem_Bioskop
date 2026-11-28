<?php

class Schedule
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($date = '', $status = '')
    {
        $sql = "SELECT
                    schedules.*,
                    movies.title AS movie_title,
                    movies.duration AS movie_duration,
                    studios.name AS studio_name,
                    (SELECT COUNT(*) FROM bookings WHERE bookings.schedule_id = schedules.id) AS booking_count
                FROM schedules
                INNER JOIN movies ON movies.id = schedules.movie_id
                INNER JOIN studios ON studios.id = schedules.studio_id
                WHERE 1 = 1";
        $params = [];

        if ($date !== '') {
            $sql .= " AND DATE(schedules.start_at) = :schedule_date";
            $params[':schedule_date'] = $date;
        }

        if ($status !== '') {
            $sql .= " AND schedules.status = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY schedules.start_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT
                schedules.*,
                movies.title AS movie_title,
                movies.duration AS movie_duration,
                studios.name AS studio_name
             FROM schedules
             INNER JOIN movies ON movies.id = schedules.movie_id
             INNER JOIN studios ON studios.id = schedules.studio_id
             WHERE schedules.id = :id"
        );
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    public function hasConflict($studioId, $startAt, $endAt, $excludeId = 0)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM schedules
             WHERE studio_id = :studio_id
               AND status = 'scheduled'
               AND start_at < :end_at
               AND end_at > :start_at
               AND id <> :exclude_id"
        );
        $stmt->execute([
            ':studio_id' => $studioId,
            ':start_at' => $startAt,
            ':end_at' => $endAt,
            ':exclude_id' => $excludeId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function hasBookings($id)
    {
        $stmt = $this->db->prepare(
            "SELECT
                (SELECT COUNT(*) FROM bookings WHERE schedule_id = :booking_schedule_id) +
                (SELECT COUNT(*) FROM booking_details WHERE schedule_id = :detail_schedule_id)"
        );
        $stmt->execute([
            ':booking_schedule_id' => $id,
            ':detail_schedule_id' => $id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO schedules (movie_id, studio_id, start_at, end_at, price, status)
             VALUES (:movie_id, :studio_id, :start_at, :end_at, :price, :status)"
        );

        return $stmt->execute([
            ':movie_id' => $data['movie_id'],
            ':studio_id' => $data['studio_id'],
            ':start_at' => $data['start_at'],
            ':end_at' => $data['end_at'],
            ':price' => $data['price'],
            ':status' => $data['status']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE schedules
             SET movie_id = :movie_id,
                 studio_id = :studio_id,
                 start_at = :start_at,
                 end_at = :end_at,
                 price = :price,
                 status = :status
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':movie_id' => $data['movie_id'],
            ':studio_id' => $data['studio_id'],
            ':start_at' => $data['start_at'],
            ':end_at' => $data['end_at'],
            ':price' => $data['price'],
            ':status' => $data['status']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM schedules WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}
