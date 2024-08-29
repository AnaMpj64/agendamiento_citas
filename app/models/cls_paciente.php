<?php
require_once("cls_conexion.php");

class paciente{
    public $id;
    public $cedula;
    public $nombres;
    public $apellidos;
    public $fecha_nacimiento;
    public $correo;
    public $telefono;
    public $ocupacion;
    public $alergias;

    public function __construct() {
        $this->id="";
        $this->cedula="";
        $this->nombres="";
        $this->apellidos="";
        $this->fecha_nacimiento="";
        $this->correo="";
        $this->telefono="";
        $this->ocupacion="";
        $this->alergias="";
    }

    public function cargarPorPaciente($paciente_id){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia = sprintf("SELECT * FROM paciente WHERE ID = " . $paciente_id);
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function cargarTodosPacientes(){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia = sprintf("SELECT * FROM paciente");
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function insertar($cedula, $nombres, $apellidos, $fecha_nacimiento, $correo, $telefono, $ocupacion, $alergias){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();
        $sentencia=sprintf("INSERT INTO paciente (CEDULA, NOMBRES, APELLIDOS, FECHA_NACIMIENTO, CORREO, TELEFONO, OCUPACION, ALERGIAS) values ('%s','%s','%s','%s','%s','%s','%s','%s')",
        $conex->real_escape_string($cedula),$conex->real_escape_string($nombres),
        $conex->real_escape_string($apellidos),$conex->real_escape_string($fecha_nacimiento),
        $conex->real_escape_string($correo), $conex->real_escape_string($telefono),
        $conex->real_escape_string($ocupacion),$conex->real_escape_string($alergias));

        $result= mysqli_query($conex, $sentencia);
        return $result;

    }


    public function actualizarPaciente($cedula, $nombres, $apellidos, $fecha_nacimiento, $correo, $telefono, $ocupacion, $alergias, $id_Persona, $user, $pass) {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
    
        // Comenzar una transacción
        mysqli_autocommit($conex, false);
        
        // Actualizar la tabla "paciente"
        $sentenciaPaciente = sprintf("UPDATE paciente SET CEDULA='%s', NOMBRES='%s', APELLIDOS='%s', FECHA_NACIMIENTO='%s', CORREO='%s', TELEFONO='%s', OCUPACION='%s', ALERGIAS='%s' WHERE ID ='%s'",
            $conex->real_escape_string($cedula),
            $conex->real_escape_string($nombres),
            $conex->real_escape_string($apellidos),
            $conex->real_escape_string($fecha_nacimiento),
            $conex->real_escape_string($correo),
            $conex->real_escape_string($telefono),
            $conex->real_escape_string($ocupacion),
            $conex->real_escape_string($alergias),
            $conex->real_escape_string($id_Persona)
        );
    
        $resultPaciente = mysqli_query($conex, $sentenciaPaciente);
    
        // Actualizar la tabla "usuarios"
        $sentenciaUsuarios = sprintf("UPDATE usuarios SET USER='%s', PASSWORD='%s' WHERE PACIENTE_ID ='%s'",
            $conex->real_escape_string($user),
            $conex->real_escape_string($pass),
            $conex->real_escape_string($id_Persona)
        );
    
        $resultUsuarios = mysqli_query($conex, $sentenciaUsuarios);
    
        // Verificar si ambas actualizaciones fueron exitosas
        if ($resultPaciente && $resultUsuarios) {
            // Si ambas actualizaciones fueron exitosas, confirmar la transacción
            mysqli_commit($conex);
            mysqli_autocommit($conex, true); // Restaurar el modo de autocommit
            return true;
        } else {
            // Si alguna actualización falló, deshacer la transacción y volver al modo de autocommit
            mysqli_rollback($conex);
            mysqli_autocommit($conex, true);
            return false;
        }
    }

}
?>