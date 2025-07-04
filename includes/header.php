<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>One Piece Characters</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
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
    
    <!-- Navigation -->
    <nav class="bg-op-navy shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-anchor text-op-gold text-2xl"></i>
                    <h1 class="text-white font-pirate text-2xl">One Piece Characters</h1>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-white hover:text-op-gold transition-colors">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                    <a href="personaje.php?action=create" class="bg-op-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Nuevo Personaje
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="index.php" class="block text-white hover:text-op-gold py-2">
                    <i class="fas fa-home mr-2"></i>Inicio
                </a>
                <a href="personaje.php?action=create" class="block text-white hover:text-op-gold py-2">
                    <i class="fas fa-plus mr-2"></i>Nuevo Personaje
                </a>
            </div>
        </div>
    </nav>

    <!-- Messages -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <main class="container mx-auto px-4 py-8">
