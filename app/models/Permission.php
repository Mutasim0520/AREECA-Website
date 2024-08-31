<?php

class Permission extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createPermissionTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createPermissionTable(){
        try{
            // SQL to create Permissons table for Users
            $sql = "CREATE TABLE IF NOT EXISTS permissions (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    model VARCHAR(100) NOT NULL,
                    raed_permission BOOLEAN NOT NULL DEFAULT TRUE,
                    write_permission BOOLEAN NOT NULL DEFAULT FALSE,
                    delete_permission BOOLEAN NOT NULL DEFAULT FALSE,
                    role_id INT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
                )";
            $this->db->exec($sql);
            echo "Permissions table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    public function getPermissionsByRoleId($roleId) {
        $sql = "SELECT * FROM permissions WHERE role_id = :role_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role_id' => $roleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

