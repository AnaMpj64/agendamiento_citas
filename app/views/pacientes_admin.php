<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <link href="../../public/css/menu.style.css" rel="stylesheet">
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
            <div class="col-2">
                <?php require_once('../../app/templates/aside.php') ?>

            </div>
            <div class="col-10">
                <div class="row h-80">
                    <div class="formulario-paciente" id="form-correo-admin">
                    
                      <img src="../../public/img/health-checkup.png" alt="Achilie Logo" height="300px" width="300px" style="margin-top: 200px; margin-left: 560px;">

                    </div>
                </div>
                <div class="row h-20" id="contenedorInferiorDerecho">
                    <div class="col-10">

                        <div class="menu-barpad">
                            <div class="menu-itemo selected" onclick="selectMenuItem(this); cargarTablaPacientes();">Historial</div>
                            <div class="menu-itemo" onclick="selectMenuItem(this); desplegarPanelPaciente();">Nuevo Paciente</div>
                            <div class="menu-itemo" onclick="selectMenuItem(this); desplegarPanelCorreo();">Nuevo Correo</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>var historialItem = document.querySelector('.menu-itemo.selected');
        if (historialItem) {
            cargarTablaPacientes(); // Carga la tabla de pacientes
            selectMenuItem(historialItem); // Selecciona el elemento "Historial"
        }</script>
</body>
</html>

<!---------Modal Actualización Historial Paciente------------------>
<div class="modal fade" id="modalActualizarHistorial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <form id="historialForm" action="../controllers/pacientes/nuevo_historial.php" method="post">
    <div class="modal-dialog cascading-modal" role="document">
      <div class="modal-content">
        <div class="modal-header primary-color white-text">
          <i class="fas fa-notes-medical fa-2x mr-3"></i>
          <h4 class="title">
            Actualización de historial del paciente
          </h4>
          <button type="button" class="close waves-effect waves-light" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="paciente_id" name="paciente_id"> <!-- ID del paciente -->
          
          <!-- Campo Diagnóstico -->
          <div class="md-form form-lg">
            <i class="fas fa-diagnoses prefix"></i>
            <label for="diagnostico">Motivo de consulta</label>
            <textarea type="text" id="diagnostico" name="diagnostico" class="md-textarea form-control"></textarea>
          </div>
          </br>
          
          <!-- Campo Recomendación -->
          <div class="md-form form-lg">
            <i class="fas fa-stethoscope prefix"></i>
            <label for="recomendacion">Recomendación o describa notas de evolución</label>
            <textarea type="text" id="recomendacion" name="recomendacion" class="md-textarea form-control"></textarea>
          </div>
          </br>
          
          <!-- Campo Resultados (opcional) -->
          <div class="md-form form-lg">
            <i class="fas fa-vials prefix"></i>
            <label for="resultados">Resultados (Opcional - sólo si se envió examen)</label>
            <textarea type="text" id="resultados" name="resultados" class="md-textarea form-control"></textarea>
          </div>
          </br>
          
          <!-- Campo Servicio Brindado -->
          <div class="md-form form-lg">
            <i class="fas fa-user-md prefix"></i>
            <label for="servicio">Servicio Brindado</label>
                        <select class="form-control" id="txt_servicio" name="txt_servicio" required>
                            <option value="Consulta">Consulta</option>
                            <option value="Terapia de electroestimulación">Terapia de electroestimulación</option>
                            <option value="Tratamiento quiropráctico">Tratamiento quiropráctico</option>
                            <option value="Rehabilitación">Rehabilitación</option>
                            <option value="Tratamientos para dolores específicos">Tratamientos para dolores específicos</option>
                        </select>
          </div>
          </br>
          
          <!-- Lista desplegable de Profesionales -->
          <div class="md-form form-lg">
            <i class="fas fa-user-nurse prefix"></i>
            <label for="profesional">Profesional Asignado</label>
            <select class="form-control" id="txt_profesional" name="txt_profesional" required>
              <!-- Aquí se cargará la lista de profesionales desde el archivo JS -->
            </select>
          </div>
          </br>
          
          <!-- Botón Guardar -->
          <div class="text-center mt-4 mb-2">
            <button type="submit" class="btn btn-primary">Guardar
              <i class="fas fa-save ml-2"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

