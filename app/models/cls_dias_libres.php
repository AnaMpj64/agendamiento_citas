<?php
require_once("cls_conexion.php");

class dias_libres {
    public $id;
    public $fecha;
    public $hora;
    public $personal_id;

    public function __construct() {
        $this->id = "";
        $this->fecha = "";
        $this->hora = "";
        $this->personal_id = "";
    }

    // Método para cargar los días libres
    public function cargarDiasLibres() {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        $query = "SELECT * FROM dias_libres";
        $result = mysqli_query($conex, $query);
        return $result;
    }

     // Método para agregar una hora no laborable a la base de datos
     public function agregarDiaLibre($fecha, $hora, $personal_id) {
        $conex = new DBConexion();
        $conex = $conex->Conectar();
        
        // Preparar la consulta
        $sentencia = sprintf("INSERT INTO dias_libres (FECHA, HORA, PERSONAL_ID) values ('%s', '%s', '%s')", 
            $conex->real_escape_string($fecha),
            $conex->real_escape_string($hora),
            $conex->real_escape_string($personal_id)
        );

        // Ejecutar la consulta
        $result = mysqli_query($conex, $sentencia);
        return $result;
    }
}
?>