<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <title>Agendamiento</title>
    <link href="../../public/css/citas.style.css" rel="stylesheet">
</head>
<body>
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

    <div class="container">
    <h1>Agendamiento de Citas</h1>

    <div class="description m-4">
        <p>Puedes agendar cita haciendo clic en los horarios que no han sido reservados ni están dentro de las horas no laborables (grises). 
        </br> Una vez desplegada la ventana de agendamiento, selecciona el tipo de servicio que deseas agendar.
        </br> ATENCION: Solo puedes cancelar una cita como máximo un día antes, para hacerlo debes ir a "Mi Perfil", elegir la cita y darle clic a cancelar.</p>
    </div>
        <div id="calendar-container">
            <div id="calendar"></div>
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
                <form action="../controllers/citas/agendar_cita.php" method="post">
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
                        <input type="hidden" class="form-control" id="txt_paciente_id" name="txt_paciente_id" value="<?php echo $paciente_id ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>