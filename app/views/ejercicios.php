<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <title>Administrador</title>
</head>
<body class="g-sidenav-show  bg-gray-100">
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
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
            <?php require_once('../../app/templates/aside.php') ?>
            </div>
            <div class="col-md-10">
                <div id="" class="m-2 mt-5">

                    <div class='panelo mt-5' id='form-eje'>
                        <div class='panel-header'>
                            <h2>Nuevo ejercicio</h2>
                        </div>
                        <div class='panel-content'>
                            <form action='' method='POST' enctype='multipart/form-data'>
                                <!-- Cuadro de imagen -->
                                <div class='form-group'>
                                    <div class='custom-file'>
                                        <input type='file' class='custom-file-input' id='imagen' name='imagen' accept='image/*' onchange='mostrarImagenSeleccionada()'>
                                        <label class='custom-file-label' for='imagen' id='imagen-label'></label>
                                    </div>

                                    <input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre del ejercicio' required>
                                </div>
                                                            
                                <!-- Campo de descripción -->
                                <div class='form-group mt-3'>
                                    <textarea class='form-control' id='descripcion' name='descripcion' placeholder='Descripción' rows='4' required></textarea>
                                </div>
                                
                                <!-- Campo de contraindicación -->
                                <div class='form-group mt-4'>
                                    <input type='text' class='form-control' id='contraindicacion' name='contraindicacion' placeholder='Contraindicación' required>
                                </div>
                                <input type='hidden' class='form-control' id='id_usuario' name='id_usuario' value='<?php echo $_SESSION['ID_USUARIO'] ?>' reandonly>
                                <!-- Botón de enviar -->
                                <button type='button' onclick='agregarNuevoEjercicio();' class='btn btn-primary mt-4'>Enviar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</body>
</html>