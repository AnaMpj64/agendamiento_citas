<?php
require_once("../../models/cls_personal.php");
$personal = new personal();
$result = $personal->cargarTodoPersonal();

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {


        echo "<option value='" . $row['ID'] . "'>Dr(a). " . $row['NOMBRES'] . " " . $row['APELLIDOS'] . "</option>";
    }
} else {
    echo "Hubo un error al mostrar la cita";
}
?>