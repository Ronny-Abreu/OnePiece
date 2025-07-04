</main>

    <!-- Footer -->
    <footer class="bg-op-navy text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-pirate text-xl mb-4 text-op-gold">One Piece Characters</h3>
                    <p class="text-gray-300">Gestiona y explora el mundo de One Piece con todos tus personajes favoritos.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-300 hover:text-op-gold transition-colors">Inicio</a></li>
                        <li><a href="personaje.php?action=create" class="text-gray-300 hover:text-op-gold transition-colors">Agregar Personaje</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Información</h4>
                    <p class="text-gray-300 text-sm">Versión <?php echo APP_VERSION; ?></p>
                    <p class="text-gray-300 text-sm">Desarrollado con PHP & MySQL</p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; <?php echo date('Y'); ?> One Piece Characters App. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
