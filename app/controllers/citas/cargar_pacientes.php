<?php
require_once("../../models/cls_paciente.php");
$paciente = new paciente();
$result = $paciente->cargarTodosPacientes();

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {


        echo "<option value='" . $row['ID'] . "'>" . $row['NOMBRES'] . " " . $row['APELLIDOS'] . "</option>";
    }
} else {
    echo "Hubo un error al mostrar la cita";
}
?>