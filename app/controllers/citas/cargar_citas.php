<?php
require_once('../../models/cls_cita.php');
$objp = new cita();
$result = $objp->cargarCitas();
$eventos = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Obtiene la fecha y hora de inicio
    $fechaInicio = $row['FECHA_CITA'];
    $horaInicio = $row['HORA_CITA'];

    // Calcula la fecha y hora de finalización (1 hora después)
    $fechaFinalizacion = $fechaInicio;
    $horaFinalizacion = date('H:i:s', strtotime($horaInicio . '+1 hour'));

    // Construye el evento con fecha de inicio y finalización
    $evento = array(
        'title' => $row['SERVICIO'],
        'start' => $fechaInicio . 'T' . $horaInicio,
        'end' => $fechaFinalizacion . 'T' . $horaFinalizacion,
        'patient_id' => $row['PACIENTE_ID'],
        'cita_id' => $row['ID'],
        'estado' => $row['ESTADO']
    );

    array_push($eventos, $evento);
}

echo json_encode($eventos);
?>