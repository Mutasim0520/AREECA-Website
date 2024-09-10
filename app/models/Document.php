<?php

class Document extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createDocumentTable();
        } catch (Exception $e) {
        }
    }

    private function createDocumentTable(){
        try{
            // SQL to create Permissons table for Users
            $sql = "CREATE TABLE IF NOT EXISTS documents (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    public function insert($name) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO documents (name) VALUES (:name)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':name', $name);

            // Execute the query
            if ($query->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }

    
}

