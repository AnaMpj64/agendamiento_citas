<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <link href="../../public/css/ejercicios.style.css" rel="stylesheet">
    <title>Ejercicios</title>
</head>
<body onload="cargarTodosEjercicios('');">
<?php 
    if(isset($_SESSION['ROL'])){
        if($_SESSION['ROL'] === 'paciente'){ 
            require_once('../../app/templates/navbarUser.php'); 
        }else if($_SESSION['ROL'] === 'Administrador'){
            require_once('../../app/templates/navbarAdmin.php');
        }
    } else {
        header("Location: ../../index.php");
    }
?>
        <div class="form-row">
            <input type="text" class="form-control col-5" id="txt_buscar" name="txt_buscar" placeholder="Buscar" onkeyup="cargarTodosEjercicios(this.value);">
        </div>

        <div id="contenedor-ejercicios">
   
        </div>
    
    </body>
</html>