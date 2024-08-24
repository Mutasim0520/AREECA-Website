<?php

class User extends Model {
    public function getUserById($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
