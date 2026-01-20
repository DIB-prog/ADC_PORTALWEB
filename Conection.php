<?php

class Conection {
    private $servername;
    private $username;
    private $password;
    private $database;
    private $conexion;
    
    public function __construct() {
        // Cargar y asignar directamente
        $config = parse_ini_file('.env');
        
        if ($config === false) {
            die("Error: No se pudo cargar el archivo .env");
        }
        
        $this->servername = $config['DB_HOST'] ?? 'localhost';
        $this->username = $config['DB_USER'] ?? 'root';
        $this->password = $config['DB_PASS'] ?? '';
        $this->database = $config['DB_NAME'] ?? 'test';
    }
    
    public function conect() {  
        $this->conexion = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
        
        return $this->conexion;
    }
    
    public function close() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>