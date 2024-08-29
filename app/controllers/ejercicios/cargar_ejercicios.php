<?php
require_once("../../models/cls_ejercicio.php");
$ejercicio = new ejercicio();
$result = $ejercicio->cargarEjercicios($_POST['parametro']);

if (mysqli_num_rows($result) > 0) {
    $num='1';
    while ($row = mysqli_fetch_array($result)) {
       $class='fondo-container1';
       if($num%2===0){
        $class='fondo-container2';
       }
        echo   "<div class='" .  $class . "'>
                    <div class='container'>
                        <img src='" . $row['IMAGEN'] . "' alt='Imagen Grande' class='image'>
                        <div class='card'>
                            <h1 class='title'>" . $row['NOMBRE_EJERCICIO'] . "</h1>
                            <p class='text'>
                                " . nl2br($row['DESCRIPCION']) . "
                            </p>
                            <p class='text'><b>Contraindicacion: " . $row['CONTRAINDICACION'] . "</b></p>
                            <p class='text'>Dr. " . $row['NOMBRES'] . " " . $row['APELLIDOS'] . "</p>
                        </div>
                    </div>
                </div>";
        $num++;
    }
} else {
    echo "<div class='fondo-container'>
                    <div class='container'>
                        <img src='../../public/uploads/no564.PNG' alt='Imagen Grande' class='image'>
                        <div class='card'>
                            <h1 class='title'>No hay ejercicios para mostrar</h1>
                            <p class='text'>
                            </p>
                        </div>
                </div>
            </div>";
}
?>