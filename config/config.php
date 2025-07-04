<?php
// Configuración general de la aplicación para reutilizar el codigo
define('APP_NAME', 'One Piece Characters');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/onepiece/');
define('UPLOAD_PATH', 'assets/images/characters/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB como máximo

session_start();

// Autoload de clases
spl_autoload_register(function ($class_name) {
    $directories = [
        'models/',
        'controllers/',
        'config/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Funciones de utilidad
function redirect($url) {
    header("Location: " . $url);
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


?>
