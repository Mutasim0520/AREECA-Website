<?php

// Start Session
session_start();

// Load Config
require_once 'config.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'app/core/' . $className . '.php';
});

?>