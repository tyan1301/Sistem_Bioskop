<?php

class Seat
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByStudio($studioId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM seats
             WHERE studio_id = :studio_id
             ORDER BY row_label, seat_number"
        );
        $stmt->execute([':studio_id' => $studioId]);

        return $stmt->fetchAll();
    }

    public function countByStudio($studioId)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM seats WHERE studio_id = :studio_id"
        );
        $stmt->execute([':studio_id' => $studioId]);

        return (int) $stmt->fetchColumn();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM seats WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    public function positionExists($studioId, $rowLabel, $seatNumber, $excludeId = 0)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM seats
             WHERE studio_id = :studio_id
               AND row_label = :row_label
               AND seat_number = :seat_number
               AND id <> :exclude_id"
        );
        $stmt->execute([
            ':studio_id' => $studioId,
            ':row_label' => $rowLabel,
            ':seat_number' => $seatNumber,
            ':exclude_id' => $excludeId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO seats (studio_id, row_label, seat_number, seat_type, is_active)
             VALUES (:studio_id, :row_label, :seat_number, :seat_type, :is_active)"
        );

        return $stmt->execute([
            ':studio_id' => $data['studio_id'],
            ':row_label' => $data['row_label'],
            ':seat_number' => $data['seat_number'],
            ':seat_type' => $data['seat_type'],
            ':is_active' => $data['is_active']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE seats
             SET row_label = :row_label,
                 seat_number = :seat_number,
                 seat_type = :seat_type,
                 is_active = :is_active
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':row_label' => $data['row_label'],
            ':seat_number' => $data['seat_number'],
            ':seat_type' => $data['seat_type'],
            ':is_active' => $data['is_active']
        ]);
    }

    public function hasBookings($id)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM booking_details WHERE seat_id = :seat_id"
        );
        $stmt->execute([':seat_id' => $id]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM seats WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }

    public function generateLayout($studioId, $rowCount, $seatsPerRow, $seatType)
    {
        $this->db->beginTransaction();

        try {
            if ($this->countByStudio($studioId) > 0) {
                $this->db->rollBack();
                return false;
            }

            $insert = $this->db->prepare(
                "INSERT INTO seats (studio_id, row_label, seat_number, seat_type, is_active)
                 VALUES (:studio_id, :row_label, :seat_number, :seat_type, 1)"
            );

            for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
                $rowLabel = chr(ord('A') + $rowIndex);

                for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                    $insert->execute([
                        ':studio_id' => $studioId,
                        ':row_label' => $rowLabel,
                        ':seat_number' => $seatNumber,
                        ':seat_type' => $seatType
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }
}
