<?php
require_once("cls_conexion.php");

class historial{
    public $id;
    public $fecha;
    public $diagnostico;
    public $recomendacion;
    public $paciente_id;

    public function __construct() {
        $this->id="";
        $this->fecha="";
        $this->diagnostico="";
        $this->recomendacion="";
        $this->paciente_id="";
    }

    public function cargarPorPaciente($paciente_id){
        $conex = new DBConexion();
        $conex = $conex->Conectar();
    
        $sentencia = sprintf("
            SELECT 
                historial.*, 
                CONCAT(paciente.NOMBRES, ' ', paciente.APELLIDOS) AS paciente_nombre,
                CONCAT(personal.NOMBRES, ' ', personal.APELLIDOS) AS profesional_nombre
            FROM historial
            INNER JOIN paciente ON historial.PACIENTE_ID = paciente.ID
            LEFT JOIN personal ON historial.PROFESIONAL_ID = personal.ID
            WHERE historial.PACIENTE_ID = %s", $paciente_id);
    
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function nuevoHistorial($diagnostico, $recomendacion, $paciente_id, $resultados, $servicio, $profesional_id){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();
        $sentencia=sprintf("INSERT INTO historial (FECHA, DIAGNOSTICO, RECOMENDACION, PACIENTE_ID, RESULTADOS, SERVICIO, PROFESIONAL_ID) values (CURDATE(),'%s','%s','%s','%s','%s','%s')",
        $conex->real_escape_string($diagnostico),$conex->real_escape_string($recomendacion),
        $conex->real_escape_string($paciente_id), $conex->real_escape_string($resultados), $conex->real_escape_string($servicio),
        $conex->real_escape_string($profesional_id));
        $result= mysqli_query($conex, $sentencia);
        return $result;

    }


}
?>