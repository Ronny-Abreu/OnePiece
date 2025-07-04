<?php 
$page_title = 'Ver Personaje - ' . $personaje->nombre;
include 'includes/header.php'; 
?>

<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="index.php" class="text-white hover:text-op-gold transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver a la lista
        </a>
    </div>
    
    <!-- Character Card -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" data-aos="fade-up">
        <div class="md:flex">
            <!-- Image Section -->
            <div class="md:w-1/2 bg-gradient-to-br from-blue-400 to-blue-600 p-8 flex items-center justify-center">
                <?php if($personaje->foto && file_exists(UPLOAD_PATH . $personaje->foto)): ?>
                    <img src="<?php echo UPLOAD_PATH . $personaje->foto; ?>" 
                         alt="<?php echo htmlspecialchars($personaje->nombre); ?>"
                         class="w-80 h-80 object-cover rounded-full border-8 border-white shadow-2xl">
                <?php else: ?>
                    <div class="w-80 h-80 bg-white bg-opacity-20 rounded-full border-8 border-white flex items-center justify-center text-white text-8xl">
                        <i class="fas fa-user-ninja"></i>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Info Section -->
            <div class="md:w-1/2 p-8">
                <div class="mb-6">
                    <h1 class="font-pirate text-4xl text-op-navy mb-2"><?php echo htmlspecialchars($personaje->nombre); ?></h1>
                    <div class="flex items-center mb-4">
                        <span class="bg-op-gold text-white px-4 py-2 rounded-full font-bold">
                            Nivel <?php echo $personaje->nivel; ?>
                        </span>
                        <span class="ml-4 text-2xl">
                            <?php echo str_repeat('⭐', $personaje->nivel); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Character Details -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-palette text-op-blue text-xl w-8"></i>
                            <h3 class="font-semibold text-gray-800">Color Representativo</h3>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-700 mr-3"><?php echo htmlspecialchars($personaje->color); ?></span>
                            <div class="w-8 h-8 rounded-full border-3 border-gray-300 shadow-md" 
                                 style="background-color: <?php echo strtolower($personaje->color); ?>"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user-tag text-op-blue text-xl w-8"></i>
                            <h3 class="font-semibold text-gray-800">Tipo/Rol</h3>
                        </div>
                        <p class="text-gray-700"><?php echo htmlspecialchars($personaje->tipo); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-chart-line text-op-blue text-xl w-8"></i>
                            <h3 class="font-semibold text-gray-800">Nivel de Poder</h3>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-1 bg-gray-200 rounded-full h-4 mr-4">
                                <div class="bg-gradient-to-r from-op-gold to-yellow-400 h-4 rounded-full transition-all duration-1000" 
                                     style="width: <?php echo ($personaje->nivel / 5) * 100; ?>%"></div>
                            </div>
                            <span class="font-bold text-op-navy"><?php echo $personaje->nivel; ?>/5</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar text-op-blue text-xl w-8"></i>
                            <h3 class="font-semibold text-gray-800">Información del Registro</h3>
                        </div>
                        <p class="text-gray-700 text-sm">
                            Creado: <?php echo date('d/m/Y H:i', strtotime($personaje->created_at)); ?>
                        </p>
                        <?php if($personaje->updated_at != $personaje->created_at): ?>
                            <p class="text-gray-700 text-sm">
                                Actualizado: <?php echo date('d/m/Y H:i', strtotime($personaje->updated_at)); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="personaje.php?action=edit&id=<?php echo $personaje->id; ?>" 
                       class="bg-op-gold text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    
                    <a href="personaje.php?action=pdf&id=<?php echo $personaje->id; ?>" 
                       class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i>Descargar PDF
                    </a>
                    
                    <a href="personaje.php?action=delete&id=<?php echo $personaje->id; ?>" 
                       onclick="return confirm('¿Estás seguro de eliminar este personaje?')"
                       class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
