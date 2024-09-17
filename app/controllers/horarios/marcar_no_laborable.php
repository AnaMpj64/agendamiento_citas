<?php
require_once('../../models/cls_dias_libres.php');
require_once('../../templates/function.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['txt_fecha_cita'];
    $hora = $_POST['txt_hora_cita'];
    $personal_id = $_SESSION['PERSONAL_ID']; // Asegurarse de que el ID del personal esté en la sesión

    // Instanciar el modelo de dias_libres
    $diasLibres = new dias_libres();
    $result = $diasLibres->agregarDiaLibre($fecha, $hora, $personal_id);

    if ($result) {
        // Responder con éxito
        echo json_encode(['status' => 'success']);
    } else {
        // Responder con error
        http_response_code(500); // Código de error
        echo json_encode(['status' => 'error']);
    }
} else {
    // Si no es una solicitud POST, devolver un error
    http_response_code(405); // Método no permitido
    echo json_encode(['status' => 'method_not_allowed']);
}
?>