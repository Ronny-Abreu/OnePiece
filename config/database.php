<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct($host = null, $db_name = null, $username = null, $password = null, $port = null) {
        $this->host = $host ?: $_ENV['DB_HOST'] ?? 'localhost';
        $this->db_name = $db_name ?: $_ENV['DB_NAME'] ?? 'onePiece_db';
        $this->username = $username ?: $_ENV['DB_USER'] ?? 'root';
        $this->password = $password ?: $_ENV['DB_PASS'] ?? '';
        $this->port = $port ?: $_ENV['DB_PORT'] ?? '3308';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
        return $this->conn;
    }

    public function testConnection() {
        try {
            $this->getConnection();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function createDatabase() {
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";charset=utf8mb4";
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->db_name . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $conn->exec($sql);
            
            return true;
        } catch(PDOException $e) {
            throw new Exception("Error creando base de datos: " . $e->getMessage());
        }
    }

    public function createTables() {
        try {
            $conn = $this->getConnection();
            $sql = "CREATE TABLE IF NOT EXISTS personajes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                color VARCHAR(50) NOT NULL,
                tipo VARCHAR(50) NOT NULL,
                nivel INT NOT NULL,
                foto VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);
            return true;
        } catch(PDOException $e) {
            throw new Exception("Error creando tablas: " . $e->getMessage());
        }
    }
}
?>
