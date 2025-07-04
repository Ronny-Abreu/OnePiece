<?php
require_once 'config/config.php';

// Check if database configuration exists
if (!file_exists('config/db_config.php')) {
    header('Location: install.php');
    exit();
}

require_once 'config/db_config.php';

try {
    $database = new Database();
    $database->getConnection();
    
    // Initialize controller and show index
    $controller = new PersonajeController();
    $controller->index();
    
} catch(Exception $e) {
    // If connection fails, redirect to installer
    header('Location: install.php');
    exit();
}
?>
