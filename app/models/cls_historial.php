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
        $sentencia = sprintf("SELECT historial.*, paciente.NOMBRES, paciente.APELLIDOS
                                FROM historial
                                INNER JOIN paciente ON historial.PACIENTE_ID = paciente.ID 
                                WHERE PACIENTE_ID = " . $paciente_id);
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }

    public function nuevoHistorial($diagnostico, $recomendacion, $paciente_id){

        $conex=new DBConexion();
        $conex=$conex ->Conectar();
        $sentencia=sprintf("INSERT INTO historial (FECHA, DIAGNOSTICO, RECOMENDACION, PACIENTE_ID) values (CURDATE(),'%s','%s','%s')",
        $conex->real_escape_string($diagnostico),$conex->real_escape_string($recomendacion),
        $conex->real_escape_string($paciente_id));
        $result= mysqli_query($conex, $sentencia);
        return $result;

    }


}
?>