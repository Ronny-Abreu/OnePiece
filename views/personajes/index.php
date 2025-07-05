<?php 
$page_title = 'Lista de Personajes';
include 'includes/header.php'; 
?>

<!-- Hero Section -->
<div class="text-center mb-12" data-aos="fade-down">
    <h1 class="font-pirate text-5xl text-white mb-4">⚓ One Piece Characters ⚓</h1>
    <p class="text-xl text-blue-200 mb-8">Explora el mundo de los piratas más famosos</p>
    
    <!-- Search Bar -->
    <div class="max-w-md mx-auto mb-8">
        <form action="personaje.php" method="GET" class="flex">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Buscar personajes..." 
                   value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>"
                   class="flex-1 px-4 py-3 rounded-l-lg border-0 focus:ring-2 focus:ring-op-gold">
            <button type="submit" class="bg-op-gold text-white px-6 py-3 rounded-r-lg hover:bg-yellow-600 transition-colors">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<?php if(isset($stats)): ?>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12" data-aos="fade-up">
    <div class="bg-white rounded-lg p-6 text-center shadow-lg">
        <i class="fas fa-users text-3xl text-op-blue mb-3"></i>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['total']; ?></h3>
        <p class="text-gray-600">Total Personajes</p>
    </div>
    <div class="bg-white rounded-lg p-6 text-center shadow-lg">
        <i class="fas fa-star text-3xl text-op-gold mb-3"></i>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo number_format($stats['nivel_promedio'], 1); ?></h3>
        <p class="text-gray-600">Nivel Promedio</p>
    </div>
    <div class="bg-white rounded-lg p-6 text-center shadow-lg">
        <i class="fas fa-crown text-3xl text-op-red mb-3"></i>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['nivel_maximo']; ?></h3>
        <p class="text-gray-600">Nivel Máximo</p>
    </div>
    <div class="bg-white rounded-lg p-6 text-center shadow-lg">
        <i class="fas fa-anchor text-3xl text-op-navy mb-3"></i>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['nivel_minimo']; ?></h3>
        <p class="text-gray-600">Nivel Mínimo</p>
    </div>
</div>
<?php endif; ?>

<!-- Agregar Personaje Button -->
<div class="text-center mb-8" data-aos="fade-up">
    <a href="personaje.php?action=create" class="bg-op-gold text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-600 transition-colors inline-block">
        <i class="fas fa-plus mr-2"></i>Agregar Nuevo Personaje
    </a>
</div>

<!-- Characters Grid -->
<div id="characters-grid-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    <?php if(isset($personajes) && count($personajes) > 0): ?>
        <?php foreach($personajes as $index => $personaje): ?>
            <div class="character-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" 
                 data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <a href="personaje.php?action=show&id=<?php echo $personaje['id']; ?>" class="block">
                <!-- Character Image -->
                <div class="relative h-64 bg-gradient-to-br from-blue-400 to-blue-600">
                    <?php if($personaje['foto'] && file_exists(UPLOAD_PATH . $personaje['foto'])): ?>
                        <img src="<?php echo UPLOAD_PATH . $personaje['foto']; ?>" 
                             alt="<?php echo htmlspecialchars($personaje['nombre']); ?>"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-white text-6xl">
                            <i class="fas fa-user-ninja"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Level Badge -->
                    <div class="absolute top-4 right-4 bg-op-gold text-white px-3 py-1 rounded-full font-bold">
                        Nivel <?php echo $personaje['nivel']; ?>
                    </div>
                </div>
                
                <!-- Character Info -->
                <div class="p-6">
                    <h3 class="font-pirate text-xl text-op-navy mb-2"><?php echo htmlspecialchars($personaje['nombre']); ?></h3>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-palette text-gray-500 w-5"></i>
                            <span class="ml-2 text-gray-700"><?php echo htmlspecialchars($personaje['color']); ?></span>
                            <div class="w-4 h-4 rounded-full ml-2 border-2 border-gray-300" 
                                 style="background-color: <?php echo strtolower($personaje['color']); ?>\"></div>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-user-tag text-gray-500 w-5"></i>
                            <span class="ml-2 text-gray-700"><?php echo htmlspecialchars($personaje['tipo']); ?></span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-star text-gray-500 w-5"></i>
                            <span class="ml-2 text-gray-700">
                                <?php echo str_repeat('⭐', $personaje['nivel']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        
                        <a href="personaje.php?action=edit&id=<?php echo $personaje['id']; ?>" 
                           class="flex-1 bg-op-gold text-white text-center py-2 rounded-lg hover:bg-yellow-600 transition-colors">\
                            <i class="fas fa-edit mr-1"></i>Editar
                        </a>
                        
                        <a href="personaje.php?action=pdf&id=<?php echo $personaje['id']; ?>" 
                           class="flex-1 bg-green-600 text-white text-center py-2 rounded-lg hover:bg-green-700 transition-colors">\
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </a>
                        
                        <a href="personaje.php?action=delete&id=<?php echo $personaje['id']; ?>" 
                           onclick="return confirm(\'¿Estás seguro de eliminar este personaje?\')"
                           class="flex-1 bg-red-600 text-white text-center py-2 rounded-lg hover:bg-red-700 transition-colors">\
                            <i class="fas fa-trash mr-1"></i>
                        </a>
                    </div>
                </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full text-center py-16">
            <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-2xl text-white mb-2">No se encontraron personajes</h3>
            <p class="text-blue-200 mb-6">
                <?php if(isset($_GET['q']) && $_GET['q']): ?>
                    No hay resultados para "<?php echo htmlspecialchars($_GET['q']); ?>"
                <?php else: ?>
                    Aún no hay personajes registrados
                <?php endif; ?>
            </p>
            <a href="personaje.php?action=create" class="bg-op-gold text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>Agregar Primer Personaje
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
