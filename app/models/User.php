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
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id ORDER BY id ASC LIMIT 1");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles($user_id) {
        $sql = "SELECT roles.* FROM roles
                JOIN user_roles ON roles.id = user_roles.role_id
                WHERE user_roles.user_id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(['user_id' => $user_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdByToken($token) {
        $sql = "SELECT id FROM users WHERE token = :token";
        $query = $this->db->prepare($sql);
        $query->execute(['token' => $token]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email){
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email ORDER BY id ASC LIMIT 1");
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function getAllUsersWithRoles() {
        $sql = "SELECT users.id AS user_id,
                        users.email AS user_email,
                        users.username,
                        roles.id AS role_id,
                        roles.name AS role_name
                FROM
                    users
                JOIN
                    user_roles ON users.id = user_roles.user_id
                JOIN
                    roles ON user_roles.role_id = roles.id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
 
}
