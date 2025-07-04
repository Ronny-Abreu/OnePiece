<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - One Piece Characters</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'op-blue': '#1e40af',
                        'op-red': '#dc2626',
                        'op-gold': '#f59e0b',
                        'op-navy': '#1e3a8a'
                    },
                    fontFamily: {
                        'pirate': ['Pirata One', 'cursive'],
                        'roboto': ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 min-h-screen font-roboto">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <i class="fas fa-anchor text-6xl text-op-gold mb-4"></i>
                <h1 class="font-pirate text-4xl text-white mb-2">One Piece Characters</h1>
                <p class="text-blue-200">Asistente de Instalación</p>
            </div>
            
            <!-- Installation Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <?php if(!isset($_POST['step']) || $_POST['step'] == 1): ?>
                    <!-- Step 1: Database Configuration -->
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-op-navy mb-2">Configuración de Base de Datos</h2>
                        <p class="text-gray-600">Ingresa los datos de conexión a tu base de datos MySQL</p>
                    </div>
                    
                    <form action="install.php" method="POST" class="space-y-6">
                        <input type="hidden" name="step" value="2">
                        
                        <div>
                            <label for="host" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-server mr-2 text-op-blue"></i>Servidor
                            </label>
                            <input type="text" id="host" name="host" value="localhost" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold">
                        </div>
                        
                        <div>
                            <label for="port" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-plug mr-2 text-op-blue"></i>Puerto
                            </label>
                            <input type="text" id="port" name="port" value="3308" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold">
                        </div>
                        
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-op-blue"></i>Usuario
                            </label>
                            <input type="text" id="username" name="username" value="root" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold">
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-op-blue"></i>Contraseña
                            </label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold">
                        </div>
                        
                        <div>
                            <label for="database" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-database mr-2 text-op-blue"></i>Nombre de la Base de Datos
                            </label>
                            <input type="text" id="database" name="database" value="onePiece_db" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold">
                        </div>
                        
                        <button type="submit" class="w-full bg-op-gold text-white py-3 px-6 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-arrow-right mr-2"></i>Probar Conexión
                        </button>
                    </form>
                    
                <?php elseif($_POST['step'] == 2): ?>
                    <!-- Step 2: Test Connection and Create Database -->
                    <?php
                    try {
                        $database = new Database($_POST['host'], $_POST['database'], $_POST['username'], $_POST['password'], $_POST['port']);
                        
                        // Test connection without database first
                        $dsn = "mysql:host=" . $_POST['host'] . ";port=" . $_POST['port'] . ";charset=utf8mb4";
                        $conn = new PDO($dsn, $_POST['username'], $_POST['password']);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Create database
                        $database->createDatabase();
                        
                        // Create tables
                        $database->createTables();
                        
                        // Save configuration
                        $config_content = "<?php\n";
                        $config_content .= "define('DB_HOST', '" . $_POST['host'] . "');\n";
                        $config_content .= "define('DB_NAME', '" . $_POST['database'] . "');\n";
                        $config_content .= "define('DB_USER', '" . $_POST['username'] . "');\n";
                        $config_content .= "define('DB_PASS', '" . $_POST['password'] . "');\n";
                        $config_content .= "define('DB_PORT', '" . $_POST['port'] . "');\n";
                        $config_content .= "?>";
                        
                        file_put_contents('config/db_config.php', $config_content);
                        
                        echo '<div class="text-center">
                                <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                                <h2 class="text-2xl font-bold text-green-600 mb-4">¡Instalación Completada!</h2>
                                <p class="text-gray-600 mb-6">La base de datos ha sido creada exitosamente y la aplicación está lista para usar.</p>
                                <a href="index.php" class="bg-op-gold text-white py-3 px-6 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
                                    <i class="fas fa-home mr-2"></i>Ir a la Aplicación
                                </a>
                              </div>';
                        
                    } catch(Exception $e) {
                        echo '<div class="text-center">
                                <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
                                <h2 class="text-2xl font-bold text-red-600 mb-4">Error de Conexión</h2>
                                <p class="text-gray-600 mb-6">No se pudo conectar a la base de datos: ' . $e->getMessage() . '</p>
                                <form action="install.php" method="POST">
                                    <input type="hidden" name="step" value="1">
                                    <button type="submit" class="bg-op-blue text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i>Volver a Intentar
                                    </button>
                                </form>
                              </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
