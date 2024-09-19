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
                    html_page_name VARCHAR(100) NOT NULL,
                    dom_id VARCHAR(100) NOT NULL,
                    dom_text  LONGTEXT NULL,
                    dom_header VARCHAR(200) NULL,
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

    public function insert($html_page_name, $dom_id, $dom_text, $dom_header, $images) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO domElements(html_page_name,dom_id,dom_text,dom_header) VALUES (:html_page_name, :dom_id, :dom_text, :dom_header)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':html_page_name', $html_page_name);
            $query->bindParam(':dom_id', $dom_id);
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

    public function getAllDomByPageName($html_page_name) {
        $sql = "SELECT 
                    domElements.id AS id,
                    domElements.dom_id AS dom_id,
                    domElements.html_page_name AS html_page_name,
                    domElements.dom_text AS dom_text,
                    domElements.dom_header AS dom_header,
                    GROUP_CONCAT(CONCAT(domElement_pictures.id, '|', domElement_pictures.file_name) SEPARATOR ',') AS images_with_ids
                FROM
                    domElements
                LEFT JOIN
                    domElement_pictures ON domElements.id = domElement_pictures.domElement_id
                WHERE 
                    domElements.html_page_name = :html_page_name
                GROUP BY
                    domElements.id,
                    domElements.html_page_name,
                    domElements.dom_id
                    
                ORDER BY
                    domElements.id DESC";
                    
        $query = $this->db->prepare($sql);
        $query->bindParam(':html_page_name', $html_page_name);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Convert the comma-separated image list into an array
        foreach ($results as &$result) {
            if (!empty($result['images_with_ids'])) {
                // Split the concatenated 'images_with_ids' field
                $images_with_ids = explode(',', $result['images_with_ids']);
                
                // Initialize an array to store the images with their id and file_name
                $images_array = [];
            
                foreach ($images_with_ids as $image_with_id) {
                    // Split the id and file_name by the pipe '|' delimiter
                    list($id, $file_name) = explode('|', $image_with_id);
            
                    // Add the id and file_name as an associative array to the images_array
                    $images_array[] = [
                        'id' => $id,
                        'file_name' => $file_name
                    ];
                }
            
                // Replace the 'images_with_ids' with the actual array of images
                $result['images'] = $images_array;
            } else {
                $result['images'] = []; // If no images, set an empty array
            }
        }
    
        return $results;
    }
    

    public function deleteDOMImage($id){
        try{
            $query = $this->db->prepare("DELETE FROM domElement_pictures WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }catch(Exception $e){
            return false;
        }
    }

    public function deleteDOM($id){
        try{
            $query = $this->db->prepare("DELETE FROM domElements WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }catch(Exception $e){
            return false;
        }
    }
    
}

