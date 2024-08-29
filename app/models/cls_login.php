<?php
require_once("../models/cls_conexion.php");

class login{

    public $id;
    public $user;
    public $password;
    public $rol;
    public $paciente_id;
    public $personal_id;

    public function __construct(){
        $this->id="";
        $this->user="";
        $this->password="";
        $this->rol="";
        $this->paciente_id="";
        $this->personal_id="";
    }

    public function verificarCredenciales($user, $password) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
        
        $escapedUser = $conexion->real_escape_string($user);
        $escapedPassword = $conexion->real_escape_string($password);

        $sentencia = sprintf(
            "SELECT * FROM usuarios WHERE USER = '%s' AND PASSWORD = '%s'",
            $escapedUser,
            $escapedPassword
        );

        $result = mysqli_query($conexion, $sentencia);

        if (mysqli_num_rows($result) === 1) {           
            return $result;
        } else {
            return false; 
        }
    }



}

?>