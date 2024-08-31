<?php

class Map extends Model {
    private $table = "maps";
    
    public function __construct() {
        parent::__construct();  // Call the parent constructor to initialize $db
        try {
            $this->createMapTable();
        } catch (Exception $e) {
            echo 'Table Creation Error: ' . $e->getMessage();
        }
    }

    private function createMapTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS maps (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    path VARCHAR(100) NOT NULL,
                    map_type VARCHAR(100),
                    district VARCHAR(100),
                    description VARCHAR(500),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ";
            $this->db->exec($sql);
            echo "Maps table created successfully.<br>";
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }     
    }
    //fetch data from map model
    public function getMaps($id=NULL) {
        if($id){
            $query = $this->db->prepare("SELECT * FROM maps WHERE id = :id");
            $query->bindParam(':id', $id);
        }
        else{
            $query = $this->db->prepare("SELECT * FROM maps");
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //insert into map model
    public function insert($name, $path, $map_type, $district, $description) {
        try {
            // Prepare an SQL statement
            $query = "INSERT INTO " . $this->table . "(name,path,map_type,district,description) VALUES (:name, :path, :map_type, :district, :description)";
            $stmt = $this->db->prepare($query);
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':path', $path);
            $stmt->bindParam(':map_type', $map_type);
            $stmt->bindParam(':district', $district);
            $stmt->bindParam(':description', $description);
            
            // Execute the query
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }

    //delete item
    public function deleteMap($id){
        if($id){
            $query = $this->db->prepare("DELETE FROM maps WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}
