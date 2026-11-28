<?php

class Studio
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db
            ->query("SELECT * FROM studios ORDER BY id DESC")
            ->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM studios WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO studios (name, capacity, description, status)
             VALUES (:name, :capacity, :description, :status)"
        );

        return $stmt->execute([
            ':name' => $data['name'],
            ':capacity' => $data['capacity'],
            ':description' => $data['description'],
            ':status' => $data['status']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE studios
             SET name = :name,
                 capacity = :capacity,
                 description = :description,
                 status = :status
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':capacity' => $data['capacity'],
            ':description' => $data['description'],
            ':status' => $data['status']
        ]);
    }

    public function hasRelatedRecords($id)
    {
        $stmt = $this->db->prepare(
            "SELECT
                (SELECT COUNT(*) FROM seats WHERE studio_id = :seat_studio_id) +
                (SELECT COUNT(*) FROM schedules WHERE studio_id = :schedule_studio_id)
             AS related_count"
        );
        $stmt->execute([
            ':seat_studio_id' => $id,
            ':schedule_studio_id' => $id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM studios WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}
