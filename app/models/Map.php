<?php

class Map extends Model {
    private $table = "maps";
    public function getUserById($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

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
                $query = $this->db->prepare("SELECT * FROM maps");
                $query->execute();
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return false;
        } catch (PDOException $e) {
            echo 'Insert error: ' . $e->getMessage();
            return false;
        }
    }
}