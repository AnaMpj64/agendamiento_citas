<?php
class DBConexion{

    public $conexion;

    protected $db;

    private $host;

    private $usuario;

    private $clave;

    private $base;

    public function __construct(){
        $this->conexion="";
        $this->db="achilie_db";
        $this->host="localhost:3306";
        $this->usuario="root";
        $this->clave="";
    }

    public function Conectar() {
        $this->conexion= mysqli_connect($this->host,$this->usuario,$this->clave,$this->db);
        if($this->conexion=='') die("Error en la conexión con mysql");
        $this->base=mysqli_select_db($this->conexion, $this->db);
        if($this->base==0) die("Error en la conexión con mysql".msqli_error($this->conexion));
        return $this->conexion;
    }


}

?>