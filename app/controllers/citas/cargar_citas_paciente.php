<?php
require_once("../../models/cls_cita.php");
$cita = new cita();
$result = $cita->citasPaciente($_POST['paciente_id']);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        // Determina el color del card según el estado
        $color = "";
        $button = ""; // Inicializa el botón vacío

        switch ($row['ESTADO']) {
            case "En espera de confirmación":
                $color = "bg-info";
                $button = "<a href='#' onclick='cancelarCitaPaciente(" . $row['ID'] . ", " . $row['PACIENTE_ID'] . ");' class='btn btn-primary'>Cancelar cita</a>";
                break;
            case "Confirmada":
                $color = "bg-success";
                $button = "<a href='#'  onclick='cancelarCitaPaciente(" . $row['ID'] . ", " . $row['PACIENTE_ID'] . ");' class='btn btn-info'>Cancelar cita</a>";
                break;
            case "Cancelada":
                $color = "bg-danger";
                break;
            case "Cumplida":
                $color = "bg-secondary";
                break;
            case "Incumplida":
                $color = "bg-warning";
                break;
            default:
                $color = "bg-info";
                break;
        }

        echo "<div class='card text-white $color mb-2' style='width: 18rem;'>
            <div class='card-header'>" . $row['FECHA_CITA'] . "</div>
                <div class='card-body'>
                    <h5 class='card-title'>" . $row['SERVICIO'] . "</h5>
                    <p class='card-text'>" . $row['ESTADO'] . "</p>
                    <p class='card-text'>Hora: " . $row['HORA_CITA'] . "</p>
                    $button <!-- Agrega el botón en función del estado -->
                </div>
            </div>";
    }
} else {
    echo "<div class='card text-white bg-danger mb-2' style='max-width: 18rem;'>
            <div class='card-header'>No hay citas para mostrar</div>
                <div class='card-body'>
                <p class='card-text'>Usted no tiene ninguna cita agendada</p>
            </div>
        </div>";
}
?>