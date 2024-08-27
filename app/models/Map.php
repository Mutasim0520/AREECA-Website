<?php

class Map extends Model {
    private $table = "maps";
    public function getUserById($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
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
