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
            <div class="col-md-6">
                <div id="" class="m-2 mt-5">
                    <div id="calendario-admin"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="formulario-admin">
                   
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<!-- Modal agendamiento -->
<div class="modal fade" id="citaModal" tabindex="-1" aria-labelledby="citaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="citaModalLabel">Agendar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/citas/agendar_cita.php" method="post" id="form-agendar-cita">
                    <div class="mb-3">
                        <label class="form-label">Fecha de la Cita:</label>
                        <input type="text" class="form-control" id="txt_fecha_cita" name="txt_fecha_cita" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hora de la Cita:</label>
                        <input type="text" class="form-control" id="txt_hora_cita" name="txt_hora_cita" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Servicio:</label>
                        <select class="form-control" id="txt_servicio" name="txt_servicio" required>
                            <option value="Consulta">Consulta</option>
                            <option value="Terapia de electroestimulación">Terapia de electroestimulación</option>
                            <option value="Tratamiento quiropráctico">Tratamiento quiropráctico</option>
                            <option value="Rehabilitación">Rehabilitación</option>
                            <option value="Tratamientos para dolores específicos">Tratamientos para dolores específicos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Paciente:</label>
                        <select class="form-control" id="txt_paciente_id" name="txt_paciente_id" required>
                           
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Agendar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="marcarNoLaborable">Marcar hora como no laborable</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal asignamiento profesional -->
<div class="modal fade" id="asignamientoProfesionalModal" tabindex="-1" aria-labelledby="citaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="citaModalLabel">Asignamiento de Personal:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">       
                    <input type="hidden" class="form-control" id="cita_id_txt" name="cita_id_txt" readonly>         
                    <div class="mb-3">
                        <label class="form-label">Escoja un profesional para atender la cita:</label>
                        <select class="form-control" id="txt_profesional" name="txt_profesional" required>
                           
                        </select>
                    </div>   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>                
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Detectar el clic en el botón "Marcar hora como no laborable"
    document.getElementById('marcarNoLaborable').addEventListener('click', function() {
        var fecha = document.getElementById('txt_fecha_cita').value;
        var hora = document.getElementById('txt_hora_cita').value;

        // Mostrar una alerta de confirmación antes de proceder
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Estás a punto de marcar esta hora como no laborable. No se podrán agendar citas a esta hora.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma, se continúa con el proceso
            if (result.isConfirmed) {
                // Hacer una solicitud AJAX
                $.ajax({
                    url: '../controllers/horarios/marcar_no_laborable.php',
                    type: 'POST',
                    data: {
                        txt_fecha_cita: fecha,
                        txt_hora_cita: hora
                    },
                    success: function(response) {
                        // Mostrar modal con el mensaje de éxito
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Hora marcada como no laborable correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(function() {
                            location.reload();  // Recargar la página después de aceptar el modal
                        });
                    },
                    error: function() {
                        // Mostrar modal de error
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al marcar la hora como no laborable.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
    });
</script>