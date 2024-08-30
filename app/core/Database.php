<?php

class Database {
    private $conn;

    public function __construct() {
        // Create the database connection
        try {
            $this->conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Method to get the database connection
    public function connect() {
        return $this->conn;
    }
    
}