<?php

class Event extends Model {
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createEventTable();
            $this->createEventPicturesTable();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function createEventTable(){
        try{
            // SQL to create Roles table
            $sql = "CREATE TABLE IF NOT EXISTS events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                date DATE NULL,
                venue VARCHAR(100) NULL,
                description LONGTEXT NOT NULL,
                intro VARCHAR(200) NOT NULL,
                cover VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function createEventPicturesTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS event_pictures (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    event_id INT NOT NULL,
                    file_name VARCHAR(100) NOT NULL,
                    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
                )
            ";
            $this->db->exec($sql);
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insert($name, $venue, $date, $description, $images, $intro, $cover) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO events (name,date,venue,description,intro,cover) VALUES (:name, :date, :venue, :description, :intro, :cover)";
            $query = $this->db->prepare($sql);
            
            // Bind parameters
            $query->bindParam(':name', $name);
            $query->bindParam(':date', $date);
            $query->bindParam(':venue', $venue);
            $query->bindParam(':description', $description);
            $query->bindParam(':intro', $intro);
            $query->bindParam(':cover', $cover);

            // Execute the query
            if ($query->execute()) {
                try{
                    $sql = $this->db->prepare("SELECT id FROM events ORDER BY id DESC LIMIT 1");
                    $sql->execute();
                    $last_event = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $images_insertion = $this->insertEventPicture($last_event[0]['id'], $images);
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

    public function insertEventPicture($event_id, $images){
        try {
            foreach ($images as $image) {
                $sql = "INSERT INTO event_pictures (event_id, file_name) VALUES (:event_id, :file_name)";
                $query = $this->db->prepare($sql);
                
                // Bind parameters
                $query->bindParam(':event_id', $event_id);
                $query->bindParam(':file_name', $image);
                $query->execute();
            }
            return true;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return $e;
        }
    }

    public function getAllEvents() {
        $sql = "SELECT 
                    events.id AS id,
                    events.name AS name,
                    events.cover AS cover,
                    events.date AS date,
                    events.description AS description,
                    events.venue AS venue,
                    events.intro AS intro,
                    GROUP_CONCAT(event_pictures.file_name) AS images
                FROM
                    events
                LEFT JOIN
                    event_pictures ON events.id = event_pictures.event_id
                GROUP BY
                    events.id
                ORDER BY
                    events.id DESC";
                    
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
                    events.cover AS cover,
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
    
    public function deleteEvent($id){
        try{
            $query = $this->db->prepare("DELETE FROM events WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }catch(Exception $e){
            return false;
        }
    }
    
}
