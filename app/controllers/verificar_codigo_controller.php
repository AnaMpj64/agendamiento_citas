<?php
require_once('../models/cls_password_reset.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificar el JSON recibido en el cuerpo de la petición
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si las claves 'email' y 'code' están presentes
    if (isset($data['email']) && isset($data['code'])) {
        $correo = $data['email'];
        $codigo = $data['code'];

        // Crear instancia del modelo
        $passwordReset = new PasswordReset();
        
        // Verificar el código
        $codigoValido = $passwordReset->verificarCodigo($codigo, $correo);

        if ($codigoValido) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'incorrect']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'missing_fields']);
    }
}
?>