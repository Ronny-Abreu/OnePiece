<?php
class Personaje {
    private $conn;
    private $table_name = "personajes";

    public $id;
    public $nombre;
    public $color;
    public $tipo;
    public $nivel;
    public $foto;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los personajes
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un personaje por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->color = $row['color'];
            $this->tipo = $row['tipo'];
            $this->nivel = $row['nivel'];
            $this->foto = $row['foto'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Crear nuevo personaje
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, color=:color, tipo=:tipo, nivel=:nivel, foto=:foto";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->nivel = htmlspecialchars(strip_tags($this->nivel));
        $this->foto = htmlspecialchars(strip_tags($this->foto));
        
        // Bind valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":nivel", $this->nivel);
        $stmt->bindParam(":foto", $this->foto);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }



    // Obtener estadísticas
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    AVG(nivel) as nivel_promedio,
                    MAX(nivel) as nivel_maximo,
                    MIN(nivel) as nivel_minimo
                  FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
