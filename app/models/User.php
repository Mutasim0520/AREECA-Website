<?php

class User extends Model {

    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createUserTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createUserTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    token VARCHAR(64) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ";
            $this->db->exec($sql);
            echo "Users table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUserById($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getRoles($user_id) {
        $sql = "SELECT roles.* FROM roles
                JOIN user_roles ON roles.id = user_roles.role_id
                WHERE user_roles.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdByToken($token) {
        $sql = "SELECT id FROM users WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
}
