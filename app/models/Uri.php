<?php

class Uri extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createUriTable();
        } catch (Exception $e) {
        }
    }

    private function createUriTable(){
        try{
            // SQL to create Permissons table for Users
            $sql = "CREATE TABLE IF NOT EXISTS uris (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    perma_link VARCHAR(200) NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    logo VARCHAR(100) NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }


    public function insert($name,$perma_link,$logo) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO uris (name,perma_link,logo) VALUES (:name, :perma_link, :logo)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':name', $name);
            $query->bindParam(':perma_link', $perma_link);
            $query->bindParam(':logo', $logo);

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

    public function getAllUris() {
        $sql = "SELECT 
                    *
                FROM
                    uris
                ORDER BY
                    name ASC";
                    
        $query = $this->db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function deleteUri($id){
        try{
            $query = $this->db->prepare("DELETE FROM uris WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }catch(Exception $e){
            return false;
        }
    }

    
}

