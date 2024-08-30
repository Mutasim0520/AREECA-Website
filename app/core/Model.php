<?php

class Model extends Database {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }
}
