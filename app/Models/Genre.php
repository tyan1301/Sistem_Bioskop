
<?php

class Genre
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Mengambil semua data genre
    public function getAll()
    {
        $query = "SELECT * FROM genres ORDER BY id DESC";

        return $this->db->query($query)->fetchAll();
    }

    // Menambahkan genre baru
    public function create($data)
    {
        $query = "INSERT INTO genres (name)
                  VALUES (:name)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':name' => $data['name']
        ]);
    }

    // Mengambil satu genre berdasarkan ID
    public function getById($id)
    {
        $query = "SELECT * FROM genres WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // Mengubah nama genre
    public function update($id, $data)
    {
        $query = "UPDATE genres
                  SET name = :name
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name']
        ]);
    }

    // Menghapus genre berdasarkan ID
    public function delete($id)
    {
        $query = "DELETE FROM genres WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
    