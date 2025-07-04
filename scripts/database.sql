-- Asistente de Configuración de Base de Datos como se pidio en uno de los puntos del proyecto

CREATE DATABASE IF NOT EXISTS onePiece_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE onePiece_db;

-- tabla personajes
CREATE TABLE IF NOT EXISTS personajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    color VARCHAR(50) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    nivel INT NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos semilla o de ejemplo
INSERT INTO personajes (nombre, color, tipo, nivel, foto) VALUES
('Monkey D. Luffy', 'Rojo', 'Capitán Pirata', 5, 'luffy.jpg'),
('Roronoa Zoro', 'Verde', 'Espadachín', 4, 'zoro.jpg'),
('Nami', 'Naranja', 'Navegante', 3, 'nami.jpg'),
('Sanji', 'Amarillo', 'Cocinero', 4, 'sanji.jpg'),
('Edward Newgate', 'Blanco', 'Yonkou', 5, 'whitebeard.jpg');