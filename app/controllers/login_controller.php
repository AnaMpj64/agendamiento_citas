<?php 
require_once('../models/cls_login.php');
$obj = new login();

$result = $obj->verificarCredenciales($_POST['user'], $_POST['pass']);

// Verifica si la consulta fue exitosa
if ($result === false) {
    // Si las credenciales son incorrectas o hay un error, redirigir a credenciales incorrectas
    header('Location: ../views/credencialesIncorrectas.php');
    echo "<div class='mt-3 text-danger' id='txt_r'>Credenciales Incorrectas</div>";
    exit();
}

// Si el inicio de sesión fue exitoso, $result debería contener un array con los datos del usuario
if (is_array($result)) {
    // Verificar si es un paciente o un personal
    if (!empty($result['PACIENTE_ID'])) {
        session_start();
        $_SESSION['PACIENTE_ID'] = $result['PACIENTE_ID'];
        $_SESSION['ROL'] = $result['ROL'];
        $_SESSION['ID_USUARIO'] = $result['ID'];
        $_SESSION['USER'] = $result['USER'];
        header('Location: ../views/inicio.php');
        exit();
    } elseif (!empty($result['PERSONAL_ID'])) {
        session_start();
        $_SESSION['PERSONAL_ID'] = $result['PERSONAL_ID'];
        $_SESSION['ROL'] = $result['ROL'];
        $_SESSION['ID_USUARIO'] = $result['ID'];
        $_SESSION['USER'] = $result['USER'];
        header('Location: ../views/inicio.php');
        exit();
    }
} else {
    // Si el resultado no es un array, es un error
    echo 'Error: El resultado de la consulta no es válido.';
    exit();
}
?>