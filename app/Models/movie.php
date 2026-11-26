
<?php

class Movie
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Mengambil semua data film
    public function getAll()
    {
        $query = "SELECT * FROM movies ORDER BY id DESC";

        return $this->db->query($query)->fetchAll();
    }

    // Menambahkan film baru
    public function create($data)
    {
        $query = "INSERT INTO movies
                  (title, synopsis, duration, director, cast, age_rating, release_date, status)
                  VALUES
                  (:title, :synopsis, :duration, :director, :cast, :age_rating, :release_date, :status)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':title' => $data['title'],
            ':synopsis' => $data['synopsis'],
            ':duration' => $data['duration'],
            ':director' => $data['director'],
            ':cast' => $data['cast'],
            ':age_rating' => $data['age_rating'],
            ':release_date' => $data['release_date'],
            ':status' => $data['status']
        ]);
    }


    // Mengambil satu film berdasarkan ID
    public function getById($id)
    {
        $query = "SELECT * FROM movies WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // Mengubah data film
    public function update($id, $data)
    {
        $query = "UPDATE movies SET
                    title = :title,
                    synopsis = :synopsis,
                    duration = :duration,
                    director = :director,
                    cast = :cast,
                    age_rating = :age_rating,
                    release_date = :release_date,
                    status = :status
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':synopsis' => $data['synopsis'],
            ':duration' => $data['duration'],
            ':director' => $data['director'],
            ':cast' => $data['cast'],
            ':age_rating' => $data['age_rating'],
            ':release_date' => $data['release_date'],
            ':status' => $data['status']
        ]);
    }

    // Menghapus film berdasarkan ID
    public function delete($id)
    {
        $query = "DELETE FROM movies WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id' => $id
        ]);
    }


}
