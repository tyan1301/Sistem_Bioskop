<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch();
    }

    public function create($name, $email, $password, $phone)
    {
        $query = "INSERT INTO users 
                  (name, email, password, phone, role)
                  VALUES 
                  (:name, :email, :password, :phone, 'customer')";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone
        ]);
    }
}
