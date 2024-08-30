<?php

class Role extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createRoleTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createRoleTable(){
        try{
            // SQL to create Roles table
            $sql = "CREATE TABLE IF NOT EXISTS roles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->exec($sql);
            echo "Roles table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
