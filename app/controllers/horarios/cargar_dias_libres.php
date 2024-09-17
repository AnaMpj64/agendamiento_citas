<?php
require_once('../../models/cls_dias_libres.php');
$diasLibresObj = new dias_libres();
$result = $diasLibresObj->cargarDiasLibres();

$diasLibres = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Añadir cada día libre al array
    $diaLibre = array(
        'fecha' => $row['FECHA'],
        'hora' => $row['HORA'],
        'personal_id' => $row['PERSONAL_ID']
    );
    array_push($diasLibres, $diaLibre);
}

echo json_encode($diasLibres);
?>