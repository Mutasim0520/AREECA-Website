<?php

class Permission extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createPermissionTable();
            $this->createPermissionRoleTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createPermissionTable(){
        try{
            // SQL to create Permissons table for Users
            $sql = "CREATE TABLE IF NOT EXISTS permissions (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    model VARCHAR(100) NOT NULL,
                    raed_permission BOOLEAN NOT NULL DEFAULT TRUE,
                    write_permission BOOLEAN NOT NULL DEFAULT FALSE,
                    delete_permission BOOLEAN NOT NULL DEFAULT FALSE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ";
            $this->db->exec($sql);
            echo "Permissions table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    private function createPermissionRoleTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS role_permissions (
                    role_id INT NOT NULL,
                    permission_id INT NOT NULL,
                    PRIMARY KEY (role_id, permission_id),
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
        )
            ";
            $this->db->exec($sql);
            echo "RolePermissions table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }    
    }
}
