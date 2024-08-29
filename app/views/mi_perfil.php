<?php require_once('../../app/templates/function.php') ?>
<?php
require_once('../models/cls_paciente.php');
$obj= new paciente();
$result=$obj->cargarPorPaciente($paciente_id);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <link href="../../public/css/profile.style.css" rel="stylesheet">
    <title>Mi perfil</title>

</head>
<body onload="cargarCitasPaciente(<?php echo $paciente_id ?>);">
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
            <div class="col-md-9">
                

                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row container d-flex justify-content-center">
                            <div class="col-xl-10 col-md-12">
                                <div class="card user-card-full">
                                    <div class="row m-l-0 m-r-0">
                                        <div class="col-sm-4 bg-c-lite-green user-profile">
                                            <div class="card-block text-center text-white">
                                                <div class="m-b-25">
                                                    <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image">
                                                </div>
                                                <h6 class="f-w-600"><?php echo $_SESSION['USER'] ?></h6>
                                                <p><?php echo $row['CEDULA'] ?></p>
                                                <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"  data-bs-toggle="modal" data-bs-target="#modalInsertarPaciente"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card-block">
                                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Información</h6>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Nombres</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['NOMBRES'] ?> <?php echo $row['APELLIDOS'] ?></h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Fecha de nacimiento</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['FECHA_NACIMIENTO'] ?></h6>
                                                        </div>
                                                    </div>

                                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Contacto</h6>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Correo</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['CORREO'] ?></h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Teléfono</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['TELEFONO'] ?></h6>
                                                        </div>
                                                    </div>
                                                
                                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Salud</h6>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Ocupación</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['OCUPACION'] ?></h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="m-b-10 f-w-600">Alergias</p>
                                                            <h6 class="text-muted f-w-400"><?php echo $row['ALERGIAS'] ?></h6>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


            </div>
            
            <!-- Columna Derecha -->
            <div class="col-md-3 position-relative">
            <h4 class="text-muted f-w-400 mt-2">Mis Citas</h4>
                <div class="row">

                    <div class="card-container position-absolute end-0 m-4" id="cards-citas">
                        
                        <div class="card text-white bg-info mb-2" style="width: 18rem;">
                            
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>

<!-----------modal-------------->

<div class="modal fade" id="modalInsertarPaciente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="insertarPacienteForm" action="../controllers/pacientes/actualizar_paciente.php" method="post">
    <div class="modal-dialog cascading-modal" role="document">
      <div class="modal-content">
        <div class="modal-header primary-color white-text">
          <i class="fas fa-user-plus fa-2x mr-3"></i>
          <h4 class="title">
            Actualización de datos
          </h4>
          <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="md-form form-lg mt-2">
            <i class="fas fa-id-card prefix"></i>
            <label for="cedula">Cédula</label>
            <input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $row['CEDULA'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-user prefix"></i>
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $row['NOMBRES'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-user prefix"></i>
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $row['APELLIDOS'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="far fa-calendar-alt prefix"></i>
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo $row['FECHA_NACIMIENTO'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-envelope prefix"></i>
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $row['CORREO'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-phone prefix"></i>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $row['TELEFONO'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-briefcase prefix"></i>
            <label for="ocupacion">Ocupación</label>
            <input type="text" id="ocupacion" name="ocupacion" class="form-control" value="<?php echo $row['OCUPACION'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-allergies prefix"></i>
            <label for="alergias">Alergias</label>
            <input type="text" id="alergias" name="alergias" class="form-control" value="<?php echo $row['ALERGIAS'] ?>">
          </div>
          <input type="hidden" id="id_paciente" name="id_paciente" class="form-control" value="<?php echo $row['ID'] ?>">
          <div class="md-form form-lgmt-2">
            <i class="fas fa-user prefix"></i>
            <label for="alergias">Usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $_SESSION['USER'] ?>">
          </div>
          <div class="md-form form-lg mt-2">
            <i class="fas fa-key prefix"></i>
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control">
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Guardar
              <i class="fas fa-save ml-2"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
