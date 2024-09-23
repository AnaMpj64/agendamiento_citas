<?php
require_once("../models/cls_conexion.php");

class PasswordReset {
    // Función para buscar el correo en paciente o personal (ya la tienes)
    public function buscarCorreo($correo) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();

        $sentencia = sprintf(
            "SELECT u.ID, u.USER, p.NOMBRES as nombre, p.CORREO as correo FROM usuarios u 
            INNER JOIN paciente p ON u.PACIENTE_ID = p.ID WHERE p.CORREO = '%s'
            UNION
            SELECT u.ID, u.USER, per.NOMBRES as nombre, per.CORREO as correo FROM usuarios u 
            INNER JOIN personal per ON u.PERSONAL_ID = per.ID WHERE per.CORREO = '%s'",
            $correo, $correo
        );

        $result = mysqli_query($conexion, $sentencia);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    // Nueva función para obtener el ID del usuario
    public function obtenerUsuarioID($correo) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
    
        // Consulta para buscar el ID de usuario basado en paciente o personal
        $sentenciaPaciente = sprintf(
            "SELECT u.ID FROM usuarios u
            INNER JOIN paciente p ON u.PACIENTE_ID = p.ID
            WHERE p.CORREO = '%s'",
            $correo
        );
    
        $sentenciaPersonal = sprintf(
            "SELECT u.ID FROM usuarios u
            INNER JOIN personal per ON u.PERSONAL_ID = per.ID
            WHERE per.CORREO = '%s'",
            $correo
        );
    
        // Primero buscamos en la tabla de pacientes
        $resultPaciente = mysqli_query($conexion, $sentenciaPaciente);
        if (mysqli_num_rows($resultPaciente) > 0) {
            $rowPaciente = mysqli_fetch_assoc($resultPaciente);
            return $rowPaciente['ID'];
        }
    
        // Si no se encontró en paciente, buscamos en la tabla de personal
        $resultPersonal = mysqli_query($conexion, $sentenciaPersonal);
        if (mysqli_num_rows($resultPersonal) > 0) {
            $rowPersonal = mysqli_fetch_assoc($resultPersonal);
            return $rowPersonal['ID'];
        }
    
        // Si no se encuentra en ninguna tabla, retornamos null
        return null;
    }

    // Nueva función para guardar el código en la tabla recuperacion_pass
    public function guardarCodigoRecuperacion($usuarioId, $codigo) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();

        $sentencia = sprintf(
            "INSERT INTO recuperacion_pass (CODIGO, FECHA, HORA, ID_USUARIO) 
            VALUES (AES_ENCRYPT('%s', 'mi_clave_secreta'), CURDATE(), CURTIME(3), %d)",
            $codigo, $usuarioId
        );

        mysqli_query($conexion, $sentencia);
    }

    // Verificar que el código sea válido
    public function verificarCodigo($codigo, $correo) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();

        // Obtener el ID del usuario a partir del correo
        $usuarioId = $this->obtenerUsuarioID($correo);

        if ($usuarioId) {
            // Verificar si el código coincide y no han pasado más de 5 minutos
            $sentencia = sprintf(
                "SELECT * FROM recuperacion_pass 
                WHERE AES_DECRYPT(CODIGO, 'mi_clave_secreta') = '%s' 
                AND ID_USUARIO = %d 
                AND TIMESTAMPDIFF(MINUTE, CONCAT(FECHA, ' ', HORA), NOW()) <= 5",
                $codigo, $usuarioId
            );
            $result = mysqli_query($conexion, $sentencia);

            return mysqli_num_rows($result) > 0;
        } else {
            return false;
        }
    }
}
?>
