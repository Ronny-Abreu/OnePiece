<?php 
$page_title = 'Editar Personaje - ' . $personaje->nombre;
include 'includes/header.php'; 
?>

<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6" data-aos="fade
include 'includes/header.php'; 
?>

<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="personaje.php?action=show&id=<?php echo $personaje->id; ?>" class="text-white hover:text-op-gold transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver al personaje
        </a>
    </div>
    
    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8" data-aos="fade-up">
        <div class="text-center mb-8">
            <h1 class="font-pirate text-3xl text-op-navy mb-2">⚓ Editar Personaje ⚓</h1>
            <p class="text-gray-600">Modifica la información de <?php echo htmlspecialchars($personaje->nombre); ?></p>
        </div>
        
        <form action="personaje.php?action=edit&id=<?php echo $personaje->id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-op-blue"></i>Nombre del Personaje
                </label>
                <input type="text" id="nombre" name="nombre" required
                       value="<?php echo htmlspecialchars($personaje->nombre); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold focus:border-transparent">
            </div>
            
            <!-- Color -->
            <div>
                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-palette mr-2 text-op-blue"></i>Color Representativo
                </label>
                <div class="flex space-x-2">
                    <input type="text" id="color" name="color" required
                           value="<?php echo htmlspecialchars($personaje->color); ?>"
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold focus:border-transparent">
                    <input type="color" id="color-picker" 
                           value="<?php echo strtolower($personaje->color); ?>"
                           class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer"
                           onchange="document.getElementById('color').value = this.value">
                </div>
            </div>
            
            <!-- Tipo -->
            <div>
                <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user-tag mr-2 text-op-blue"></i>Tipo/Rol
                </label>
                <select id="tipo" name="tipo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-op-gold focus:border-transparent">
                    <option value="">Selecciona un tipo</option>
                    <?php 
                    $tipos = [
                        'Capitán Pirata', 'Espadachín', 'Navegante', 'Cocinero', 'Francotirador',
                        'Doctor', 'Arqueólogo', 'Músico', 'Timonel', 'Yonkou', 'Shichibukai',
                        'Almirante', 'Vicealmirante', 'Revolucionario', 'Otro'
                    ];
                    foreach($tipos as $tipo): ?>
                        <option value="<?php echo $tipo; ?>" <?php echo ($personaje->tipo == $tipo) ? 'selected' : ''; ?>>
                            <?php echo $tipo; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Nivel -->
            <div>
                <label for="nivel" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-star mr-2 text-op-blue"></i>Nivel de Poder (1-5)
                </label>
                <div class="flex items-center space-x-4">
                    <input type="range" id="nivel" name="nivel" min="1" max="5" value="<?php echo $personaje->nivel; ?>"
                           class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                           oninput="updateNivelDisplay(this.value)">
                    <div class="flex items-center space-x-2">
                        <span id="nivel-number" class="font-bold text-op-navy text-lg"><?php echo $personaje->nivel; ?></span>
                        <span id="nivel-stars" class="text-xl"><?php echo str_repeat('⭐', $personaje->nivel); ?></span>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    <span id="nivel-description"></span>
                </div>
            </div>
            
            <!-- Foto Actual -->
            <?php if($personaje->foto && file_exists(UPLOAD_PATH . $personaje->foto)): ?>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image mr-2 text-op-blue"></i>Foto Actual
                </label>
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <img src="<?php echo UPLOAD_PATH . $personaje->foto; ?>" 
                         alt="<?php echo htmlspecialchars($personaje->nombre); ?>"
                         class="w-20 h-20 object-cover rounded-lg">
                    <div>
                        <p class="text-sm text-gray-700">Imagen actual del personaje</p>
                        <p class="text-xs text-gray-500">Selecciona una nueva imagen para reemplazarla</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Nueva Foto -->
            <div>
                <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-camera mr-2 text-op-blue"></i>Nueva Foto del Personaje (Opcional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-op-gold transition-colors">
                    <input type="file" id="foto" name="foto" accept="image/*"
                           class="hidden" onchange="previewImage(this)">
                    <label for="foto" class="cursor-pointer">
                        <div id="image-preview" class="mb-4">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Haz clic para seleccionar una nueva imagen</p>
                            <p class="text-sm text-gray-500">JPG, PNG, GIF (máx. 5MB)</p>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex space-x-4 pt-6">
                <button type="submit" 
                        class="flex-1 bg-op-gold text-white py-3 px-6 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
                    <i class="fas fa-save mr-2"></i>Actualizar Personaje
                </button>
                
                <a href="personaje.php?action=show&id=<?php echo $personaje->id; ?>" 
                   class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold text-center hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updateNivelDisplay(value) {
    const descriptions = {
        1: 'Novato',
        2: 'Principiante', 
        3: 'Intermedio',
        4: 'Avanzado',
        5: 'Legendario'
    };
    
    document.getElementById('nivel-number').textContent = value;
    document.getElementById('nivel-stars').textContent = '⭐'.repeat(value);
    document.getElementById('nivel-description').textContent = descriptions[value];
}

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg mx-auto mb-2">
                <p class="text-sm text-gray-600">Nueva imagen seleccionada</p>
                <p class="text-xs text-gray-500">Haz clic para cambiar</p>
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize nivel description on page load
document.addEventListener('DOMContentLoaded', function() {
    const currentNivel = <?php echo $personaje->nivel; ?>;
    updateNivelDisplay(currentNivel);
});
</script>

<?php include 'includes/footer.php'; ?>
