<?php
require_once 'config/config.php';

class PersonajeController {
    private $db;
    private $personaje;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->personaje = new Personaje($this->db);
    }

    public function index() {
        $stmt = $this->personaje->getAll();
        $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stats = $this->personaje->getStats();
        
        include 'views/personajes/index.php';
    }

    public function show($id) {
        if($this->personaje->getById($id)) {
            include 'views/personajes/show.php';
        } else {
            $_SESSION['error'] = "Personaje no encontrado";
            redirect('index.php');
        }
    }

    public function create() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->personaje->nombre = sanitize($_POST['nombre']);
                $this->personaje->color = sanitize($_POST['color']);
                $this->personaje->tipo = sanitize($_POST['tipo']);
                $this->personaje->nivel = (int)$_POST['nivel'];
                
                // Manejar subida de imagen
                if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                    $this->personaje->foto = uploadImage($_FILES['foto']);
                } else {
                    $this->personaje->foto = null;
                }
                
                if($this->personaje->create()) {
                    $_SESSION['success'] = "Personaje creado exitosamente";
                    redirect('index.php');
                } else {
                    throw new Exception("Error al crear el personaje");
                }
            } catch(Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }
        
        include 'views/personajes/create.php';
    }
    //editar personaje
    public function edit($id) {
        if(!$this->personaje->getById($id)) {
            $_SESSION['error'] = "Personaje no encontrado";
            redirect('index.php');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->personaje->nombre = sanitize($_POST['nombre']);
                $this->personaje->color = sanitize($_POST['color']);
                $this->personaje->tipo = sanitize($_POST['tipo']);
                $this->personaje->nivel = (int)$_POST['nivel'];
                
                // Manejar subida de imagen
                if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                    // Eliminar imagen anterior si existe
                    if($this->personaje->foto && file_exists(UPLOAD_PATH . $this->personaje->foto)) {
                        unlink(UPLOAD_PATH . $this->personaje->foto);
                    }
                    $this->personaje->foto = uploadImage($_FILES['foto']);
                }
                
                if($this->personaje->update()) {
                    $_SESSION['success'] = "Personaje actualizado exitosamente";
                    redirect('personaje.php?action=show&id=' . $id);
                } else {
                    throw new Exception("Error al actualizar el personaje");
                }
            } catch(Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }
        
        include 'views/personajes/edit.php';
    }
    //eliminar personaje
    public function delete($id) {
        if($this->personaje->getById($id)) {
            // Eliminar imagen si existe
            if($this->personaje->foto && file_exists(UPLOAD_PATH . $this->personaje->foto)) {
                unlink(UPLOAD_PATH . $this->personaje->foto);
            }
            
            if($this->personaje->delete()) {
                $_SESSION['success'] = "Personaje eliminado exitosamente";
            } else {
                $_SESSION['error'] = "Error al eliminar el personaje";
            }
        } else {
            $_SESSION['error'] = "Personaje no encontrado";
        }
        
        redirect('index.php');
    }
    //buscar personaje
    public function search() {
        $keywords = isset($_GET['q']) ? sanitize($_GET['q']) : '';
        
        if($keywords) {
            $stmt = $this->personaje->search($keywords); 
            $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->personaje->getAll(); //obtener todos los personajes
            $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        $stats = $this->personaje->getStats(); //obtener estadisticas
        include 'views/personajes/index.php';
    }

    public function generatePDF($id) {
        if(!$this->personaje->getById($id)) {
            $_SESSION['error'] = "Personaje no encontrado";
            redirect('index.php');
        }

        //generar pdf
        require_once 'includes/pdf_generator.php';
        
        try {
            $pdfGenerator = new PDFGenerator();
            $pdfGenerator->generatePersonajePDF($this->personaje);
        } catch(Exception $e) {
            $_SESSION['error'] = "Error al generar PDF: " . $e->getMessage();
            redirect('personaje.php?action=show&id=' . $id);
        }
    }
}
?>
