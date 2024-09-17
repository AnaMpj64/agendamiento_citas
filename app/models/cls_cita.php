<?php
require_once("cls_conexion.php");

class cita{
    public $id;
    public $fecha_reserva;
    public $fecha_cita;
    public $hora_cita;
    public $servicio;
    public $estado;
    public $personal_id;
    public $paciente_id;

    public function __construct() {
        $this->id="";
        $this->fecha_reserva="";
        $this->fecha_cita="";
        $this->hora_cita="";
        $this->servicio="";
        $this->estado="";
        $this->personal_id="";
        $this->paciente_id="";
    }

    public function agendar($fecha_cita, $hora_cita, $servicio, $paciente_id, $profesional_id){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();
        $sentencia=sprintf("INSERT INTO citas (FECHA_RESERVA, FECHA_CITA, HORA_CITA, SERVICIO, ESTADO, PACIENTE_ID, PERSONAL_SOLICITADO_ID) values (CURDATE(),'%s','%s','%s','%s','%s','%s')",$conex->real_escape_string($fecha_cita),$conex->real_escape_string($hora_cita),$conex->real_escape_string($servicio),$conex->real_escape_string('En espera de confirmación'),$conex->real_escape_string($paciente_id),$conex->real_escape_string($profesional_id));
        $result= mysqli_query($conex, $sentencia);
        return $result;

    }

    public function cargarCitas(){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();
        $sentencia=sprintf("SELECT * FROM citas");
        $result= mysqli_query($conex, $sentencia);
        return $result;

    }

    public function citasPaciente($paciente_id){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia = sprintf("SELECT * FROM citas WHERE PACIENTE_ID = " . $paciente_id . " ORDER BY FECHA_CITA DESC");
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }
       
    public function cancelarCita($id){
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
    
        $escapedId = $conexion->real_escape_string($id);
    
        $sentencia = sprintf(
            "UPDATE citas SET ESTADO = 'Cancelada' WHERE ID = %s",
            $escapedId
        );
    
        $result = mysqli_query($conexion, $sentencia);
    
        return $result;
    }

    /* public function cargarPorCita($cita_id){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $sentencia = sprintf("SELECT * FROM citas WHERE ID = " . $cita_id);
        $result = mysqli_query($conex, $sentencia);
        return $result;
    } */

    public function cargarPorCita($cita_id) {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
    
        $sentencia = sprintf("
            SELECT 
                c.*, 
                CONCAT(p_solicitado.NOMBRES, ' ', p_solicitado.APELLIDOS) AS prof_solicitado,
                CONCAT(p_asignado.NOMBRES, ' ', p_asignado.APELLIDOS) AS prof_asignado
            FROM citas c
            LEFT JOIN personal p_solicitado ON c.PERSONAL_SOLICITADO_ID = p_solicitado.ID
            LEFT JOIN personal p_asignado ON c.PERSONAL_ID = p_asignado.ID
            WHERE c.ID = %s", $cita_id);
    
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function confirmarCita($idCita, $idPersonal){
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
    
        $escapedId = $conexion->real_escape_string($idCita);
        $escapedIdPersonal = $conexion->real_escape_string($idPersonal);
    
        $sentencia = sprintf(
            "UPDATE citas SET ESTADO = 'Confirmada', PERSONAL_ID = %s  WHERE ID = %s",
            $escapedIdPersonal,
            $escapedId
        );
    
        $result = mysqli_query($conexion, $sentencia);
    
        return $result;
    }

    public function cumplidaCita($id, $parametro){
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
    
        $escapedId = $conexion->real_escape_string($id);
        $escapedParametro = $conexion->real_escape_string($parametro);
    
        $sentencia = sprintf(
            "UPDATE citas SET ESTADO = '%s' WHERE ID = %s",
            $escapedParametro,
            $escapedId
        );
    
        $result = mysqli_query($conexion, $sentencia);
    
        return $result;
    }
}
?>