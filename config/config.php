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

function uploadImage($file, $target_dir = UPLOAD_PATH) {
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Verificar si es una imagen real
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        throw new Exception("El archivo no es una imagen.");
    }
    
    // Verificar tamaño del archivo(com max 5mb)
    if ($file["size"] > MAX_FILE_SIZE) {
        throw new Exception("El archivo es demasiado grande.");
    }
    
    // formatos de archivo permitidos
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        throw new Exception("Solo se permiten archivos JPG, JPEG, PNG y GIF.");
    }
    
    // Generando nombre único a la imagen
    $unique_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) { // si se sube la imagen vamos a retornar el nombre de la imagen
        return $unique_name;
    } else {
        throw new Exception("Error al subir el archivo."); 
    }
}
?>
