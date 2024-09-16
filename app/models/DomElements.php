<?php

class DomElements extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createDomElementsTable(); 
            $this->createDomPicturesTable();
        } catch (Exception $e) {
        }
    }

    private function createDomElementsTable(){
        try{
            // SQL to create Permissons table for Users
            $sql = "CREATE TABLE IF NOT EXISTS domElements (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    page_url VARCHAR(100) NOT NULL,
                    dom_id VARCHAR(100) NOT NULL,
                    dom_type VARCHAR(20) NULL,
                    dom_text  VARCHAR(500) NULL,
                    dom_header VARCHAR(100) NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    private function createDomPicturesTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS domElement_pictures (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    domElement_id INT NOT NULL,
                    file_name VARCHAR(50) NOT NULL,
                    FOREIGN KEY (domElement_id) REFERENCES domElements(id) ON DELETE CASCADE
                )
            ";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insert($page_url, $dom_id, $dom_type, $dom_text, $dom_header, $images) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO domElements(page_url,dom_id,dom_type,dom_text,dom_header) VALUES (:page_url, :dom_id, :dom_type, :dom_text, :dom_header)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':page_url', $page_url);
            $query->bindParam(':dom_id', $dom_id);
            $query->bindParam(':dom_type', $dom_type);
            $query->bindParam(':dom_text', $dom_text);
            $query->bindParam(':dom_header', $dom_header);

            // Execute the query
            if ($query->execute()) {
                try{
                    $sql = $this->db->prepare("SELECT id FROM domElements ORDER BY id DESC LIMIT 1");
                    $sql->execute();
                    $last_event = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $images_insertion = $this->insertDomPictures($last_event[0]['id'], $images);
                    if($images_insertion) return true;
                    else return false;
                }catch (PDOException $e) {
                    return false;
                }
                
            }
            return false;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }

    public function insertDomPictures($domElement_id, $images){
        try {
            foreach ($images as $image) {
                $sql = "INSERT INTO domElement_pictures (domElement_id, file_name) VALUES (:domElement_id, :file_name)";
                $query = $this->db->prepare($sql);
                
                // Bind parameters
                $query->bindParam(':domElement_id', $domElement_id);
                $query->bindParam(':file_name', $image);
                $query->execute();
            }
            return true;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return $e;
        }
    }

    public function getAllDoms($domID=NULL) {
        $sql = "SELECT 
                    domElements.dom_id AS dom_id,
                    domElements.dom_text AS dom_text,
                    domElements.dom_header AS dom_header,
                    GROUP_CONCAT(domElement_pictures.file_name) AS images
                FROM
                    domElements
                LEFT JOIN
                    domElement_pictures ON domElements.id = domElement_pictures.domElement_id
                GROUP BY
                    domElements.dom_id
                ORDER BY
                    domElements.dom_id ASC";
        if($domID){
            $sql = $sql . " WHERE domElements.dom_id = $domID";
        }
                    
        $query = $this->db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Convert the comma-separated image list into an array
        foreach ($results as &$row) {
            $row['images'] = $row['images'] ? explode(',', $row['images']) : [];  // Handle empty or null case
        }
    
        return $results;
    }

    public function getEventByID($id) {
        $sql = "SELECT 
                    events.id AS id,
                    events.name AS name,
                    events.date AS date,
                    events.description AS description,
                    events.venue AS venue,
                    events.intro AS intro,
                    GROUP_CONCAT(event_pictures.file_name) AS images
                FROM
                    events
                LEFT JOIN
                    event_pictures ON events.id = event_pictures.event_id
                WHERE
                    events.id = :id
                GROUP BY
                    events.id
                ORDER BY
                    events.id DESC";
                    
        $query = $this->db->prepare($sql);
        $query->execute(['id' => $id]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Convert the comma-separated image list into an array
        foreach ($results as &$row) {
            $row['images'] = $row['images'] ? explode(',', $row['images']) : [];  // Handle empty or null case
        }
    
        return $results;
    }

    
}

