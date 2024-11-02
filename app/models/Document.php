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
                    real_name VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    public function insert($name,$real_name) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO documents (name,real_name) VALUES (:name, :real_name)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':name', $name);
            $query->bindParam(':real_name', $real_name);

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

    public function getAllDocuments() {
        $sql = "SELECT 
                    *
                FROM
                    documents
                ORDER BY
                    name ASC";
                    
        $query = $this->db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function deleteDocument($id){
        try{
            $query = $this->db->prepare("DELETE FROM documents WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }catch(Exception $e){
            return false;
        }
    }

    public function getDocumentById($id){
        $sql = "SELECT 
                    *
                FROM
                    documents
                WHERE
                    id = :id
                ORDER BY
                    name ASC";
                    
        $query = $this->db->prepare($sql);
        query->bindParam(':id', $id);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    
}

