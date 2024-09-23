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

        $sentencia = sprintf(
            "SELECT ID FROM usuarios 
            WHERE ID IN (SELECT PACIENTE_ID FROM paciente WHERE CORREO = '%s'
                         UNION 
                         SELECT PERSONAL_ID FROM personal WHERE CORREO = '%s')",
            $correo, $correo
        );

        $result = mysqli_query($conexion, $sentencia);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['ID'];
        } else {
            return null;
        }
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
