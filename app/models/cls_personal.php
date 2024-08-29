<?php
require_once("cls_conexion.php");

class personal{
    public $id;
    public $cedula;
    public $nombres;
    public $apellidos;
    public $fecha_nacimiento;
    public $correo;
    public $telefono;
    public $cargo;
    public $sueldo;
    public $especialidad;

    public function __construct() {
        $this->id="";
        $this->cedula="";
        $this->nombres="";
        $this->apellidos="";
        $this->fecha_nacimiento="";
        $this->correo="";
        $this->telefono="";
        $this->cargo="";
        $this->sueldo="";
        $this->especialidad="";
    }

    public function cargarTodoPersonal(){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia = sprintf("SELECT * FROM personal");
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

}
?>