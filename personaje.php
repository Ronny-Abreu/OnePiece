<?php
require_once 'config/config.php';

if (!file_exists('config/db_config.php')) {
    header('Location: install.php');
    exit();
}

require_once 'config/db_config.php';

try {
    $database = new Database();
    $database->getConnection();
    
    $controller = new PersonajeController();
    
    $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    
    //switch para las acciones
    switch($action) {
        case 'show':
            if($id) {
                $controller->show($id);
            } else {
                redirect('index.php');
            }
            break;
            
        case 'create':
            $controller->create();
            break;
            
        case 'edit':
            if($id) {
                $controller->edit($id);
            } else {
                redirect('index.php');
            }
            break;
            
        case 'delete':
            if($id) {
                $controller->delete($id);
            } else {
                redirect('index.php');
            }
            break;
            
        case 'search':
            $controller->search();
            break;
            
        case 'pdf':
            if($id) {
                $controller->generatePDF($id);
            } else {
                redirect('index.php');
            }
            break;
            
        default:
            $controller->index();
            break;
    }
    
} catch(Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: install.php');
    exit();
}
?>
