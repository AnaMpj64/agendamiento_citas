<?php
require_once('../models/cls_login.php');
$obj= new login();
$result=$obj->verificarCredenciales(
    $_POST['user'],
    $_POST['pass']);

    if ($result !== false && mysqli_num_rows($result) === 1) {   
        $fila = mysqli_fetch_assoc($result);
        if (!empty($fila['PACIENTE_ID'])) {
           
            session_start();
            $_SESSION['PACIENTE_ID'] = $fila['PACIENTE_ID'];
            $_SESSION['ROL'] = $fila['ROL'];
            $_SESSION['ID_USUARIO'] = $fila['ID'];
            $_SESSION['USER'] = $fila['USER'];
            header('Location: ../views/inicio.php');
            exit();
        } elseif (!empty($fila['PERSONAL_ID'])) {
            
            session_start();
            $_SESSION['PERSONAL_ID'] = $fila['PERSONAL_ID'];
            $_SESSION['ROL'] = $fila['ROL'];
            $_SESSION['ID_USUARIO'] = $fila['ID'];
            $_SESSION['USER'] = $fila['USER'];
            header('Location: ../views/inicio.php');
            exit();
        }
    } else {
        
        echo "<div class='mt-3 text-danger' id='txt_r'>Credenciales Incorrectas </div>";
        exit();
    }

?>