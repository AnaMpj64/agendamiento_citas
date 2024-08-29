<?php
require_once("cls_conexion.php");

class ejercicio{

    public $id;
    public $nombre_ejercicio;
    public $descripcion;
    public $imagen;
    public $contraindicacion;
    public $usuarios_id;

    public function __construct(){
        $this->id="";
        $this->nombre_ejercicio="";
        $this->descripcion="";
        $this->imagen="";
        $this->contraindicacion="";
        $this->usuarios_id="";
    }

    public function agregarEjercicio($nombre, $descripcion, $imagen, $contraindicacion, $usuario) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
        
        $escapedNombre = $conexion->real_escape_string($nombre);
        $escapedDescripcion = $conexion->real_escape_string($descripcion);
        $escapedImagen = $conexion->real_escape_string($imagen);
        $escapedContraindicacion = $conexion->real_escape_string($contraindicacion);
        $escapedUsuario = $conexion->real_escape_string($usuario);

        $sentencia = sprintf(
            "insert into ejercicios (NOMBRE_EJERCICIO, 	DESCRIPCION, IMAGEN, CONTRAINDICACION, USUARIOS_ID) values ('%s', '%s', '%s', '%s', '%s')",
            $escapedNombre,
            $escapedDescripcion,
            $escapedImagen,
            $escapedContraindicacion,
            $escapedUsuario
        );
        
        $result = mysqli_query($conexion, $sentencia);
        
        return $result;
    }

    public function cargarEjercicios($parametro){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();

        if($parametro==''){
            $sentencia=sprintf("SELECT ejercicios.*, personal.NOMBRES, personal.APELLIDOS
                            FROM ejercicios
                            INNER JOIN usuarios ON usuarios.ID = ejercicios.USUARIOS_ID
                            INNER JOIN personal ON usuarios.PERSONAL_ID = personal.ID");
        }
        else
        {
            $sentencia = sprintf("SELECT ejercicios.*, personal.NOMBRES, personal.APELLIDOS
                            FROM ejercicios
                            INNER JOIN usuarios ON usuarios.ID = ejercicios.USUARIOS_ID
                            INNER JOIN personal ON usuarios.PERSONAL_ID = personal.ID
                            WHERE NOMBRE_EJERCICIO LIKE '%%%s%%'", $parametro);

        }


        $result= mysqli_query($conex, $sentencia);
        return $result;

    }

}

?>