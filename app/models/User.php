<?php

class User extends Model {

    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createUserTable();
            $this->createUserRoleTable();
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
                    token VARCHAR(64) NOT NULL UNIQUE DEFAULT (CONCAT(SUBSTRING(MD5(RAND()), 1, 32))),
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

    private function createUserRoleTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS user_roles (
                    user_id INT NOT NULL,
                    role_id INT NOT NULL,
                    PRIMARY KEY (user_id, role_id),
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
                )
            ";
            $this->db->exec($sql);
            echo "User Roles table created successfully.<br>";
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
}
