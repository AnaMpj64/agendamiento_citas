<?php
class DBConexion{

    public $conexion;

    protected $db;

    private $host;

    private $usuario;

    private $clave;

    private $base;

    public function __construct(){
        $this->conexion = "";
        $this->db = "dsrcluytm2cs8cfe";  // Base de datos
        $this->host = "d9c88q3e09w6fdb2.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306";  // Host y puerto
        $this->usuario = "kp8udz7nhrmtjs73";  // Usuario
        $this->clave = "udjyiikf1y5xdpp9";  // Contraseña
    }

    public function Conectar() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
        if(!$this->conexion) {
            die("Error en la conexión con MySQL: " . mysqli_connect_error());
        }
        return $this->conexion;
    }
}
?>