# Proyecto One Piece

Este es un proyecto de aplicación web básico diseñado para gestionar información sobre personajes del popular anime y manga "One Piece". Permite a los usuarios crear, leer, actualizar y eliminar personajes, así como generar informes en formato PDF.

## Características

*   **Gestión de Personajes (CRUD):**
    *   Crear nuevos personajes con sus detalles.
    *   Ver una lista de todos los personajes.
    *   Editar la información de los personajes existentes.
    *   Eliminar personajes de la base de datos.
*   **Generación de PDF:** Genera documentos PDF con los datos de los personajes, utilizando la librería DOMPDF.
*   **Base de Datos MySQL:** Almacenamiento persistente de los datos de los personajes.
*   **Interfaz de Usuario Sencilla:** Navegación y formularios intuitivos para la gestión de datos.

## Tecnologías Utilizadas

*   **Backend:** PHP
*   **Base de Datos:** MySQL
*   **Frontend:** HTML, CSS, JavaScriptM Tailwindcss, Boostrap y AOS para animación de scroll.
*   **Dependencias PHP (gestionadas con Composer):**
    *   `dompdf/dompdf`: Para la generación de archivos PDF.
    *   `masterminds/html5`: Un parser de HTML5.
    *   `phenx/php-font-lib`: Una librería para manipular fuentes.
    *   `phenx/php-svg-lib`: Una librería para manipular SVG.
    *   `sabberworm/php-css-parser`: Un parser de CSS.

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

1.  **Clonar el Repositorio:**
    ```bash
    git clone https://github.com/Ronny-Abreu/OnePiece.git # Reemplaza con la URL de tu repositorio
    cd OnePiece
    ```

2.  **Configurar un Servidor Web:**
    Asegúrate de tener un servidor web como Apache o Nginx (se recomienda usar XAMPP para un entorno de desarrollo fácil).
    Coloca el contenido de este repositorio en el directorio `htdocs` de XAMPP (o el directorio raíz de tu servidor web).

3.  **Configurar la Base de Datos:**
    a.  Crea una base de datos MySQL. Puedes usar phpMyAdmin (incluido en XAMPP) o la línea de comandos.
    b.  Importa el script SQL `scripts/database.sql` en tu nueva base de datos. Este script creará la tabla `personajes` y poblará algunos datos de ejemplo.
    c.  Edita el archivo `config/db_config.php` con tus credenciales de la base de datos:
        ```php
        // config/db_config.php
        <?php
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'tu_usuario_db'); 
        define('DB_PASSWORD', 'tu_password_db');
        define('DB_NAME', 'nombre_de_tu_base_de_datos'); // Reemplaza con el nombre de tu DB
        ?>
        ```

4.  **Instalar Dependencias de Composer:**
    Navega al directorio raíz del proyecto (`OnePiece/`) en tu terminal e instala las dependencias de PHP:
    ```bash
    composer install
    ```
    Si no tienes Composer instalado, puedes descargarlo desde [getcomposer.org](https://getcomposer.org/).

## Uso

Una vez que la instalación esté completa, puedes acceder a la aplicación a través de tu navegador web:

*   Abre tu navegador y navega a `http://localhost/OnePiece/` (o la URL donde hayas configurado el proyecto).
*   Desde la página principal, podrás navegar por la lista de personajes, agregar nuevos, editar o eliminarlos.
*   La opción de generar PDF estará disponible en la interfaz de usuario.

## Estructura de Carpetas

*   `assets/`: Contiene archivos CSS, JavaScript e imágenes.
    *   `css/`: Archivos de hojas de estilo.
    *   `images/`: Imágenes de los personajes y otros activos visuales.
    *   `js/`: Archivos JavaScript para funcionalidades del frontend.
*   `config/`: Archivos de configuración de la aplicación y la base de datos.
*   `controllers/`: Lógica de negocio y manejo de solicitudes (por ejemplo, `PersonajeController.php`).
*   `includes/`: Archivos PHP reutilizables como encabezados y pies de página (`header.php`, `footer.php`). También incluye el generador de PDF (`pdf_generator.php`).
*   `models/`: Clases que representan las entidades de la base de datos y la lógica de interacción con la DB (por ejemplo, `Personaje.php`).
*   `scripts/`: Scripts SQL para la base de datos (`database.sql`).
*   `vendor/`: Dependencias de Composer instaladas.
*   `views/`: Archivos de vista (HTML/PHP) que definen la interfaz de usuario.
    *   `install/`: Archivos relacionados con la instalación inicial (si aplica).
    *   `personajes/`: Vistas específicas para la gestión de personajes (crear, editar, mostrar, listar).
*   `index.php`: El punto de entrada principal de la aplicación.
*   `personaje.php`: Posiblemente un punto de entrada o script específico para operaciones con personajes.
*   `install.php`: Script de instalación inicial (si aplica).
*   `LICENSE`: Archivo de licencia del proyecto.
