<?php
require_once('../models/cls_password_reset.php');
require_once('../models/cls_login.php'); // Incluye el modelo de usuarios para la actualización de contraseña

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $correo = $data['email'];
    $nuevaContrasena = $data['password'];

    // Instancia del modelo de recuperación
    $passwordReset = new PasswordReset();

    // Verificar que el correo existe y el código es válido
    $usuario = $passwordReset->buscarCorreo($correo);
    
    if ($usuario) {
        // Cifrar la nueva contraseña antes de almacenarla
        //$contrasenaCifrada = password_hash($nuevaContrasena, PASSWORD_BCRYPT);

        // Instancia del modelo de login para actualizar la contraseña
        $loginModel = new login();
        $resultado = $loginModel->actualizarContrasena($usuario['ID'], $nuevaContrasena);

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la contraseña']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el usuario']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
