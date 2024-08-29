<?php
require_once("../../models/cls_cita.php");
$cita = new cita();
$result = $cita->cargarPorCita($_POST['cita_id']);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {
        require_once("../../models/cls_paciente.php");
        $paciente = new paciente();
        $resultPac = $paciente->cargarPorPaciente($row['PACIENTE_ID']);
        $pac = mysqli_fetch_array($resultPac);


        $buttonCancel = ""; 
        $buttonConfirm = "";
        $buttonComplete = "";

        switch ($row['ESTADO']) {
            case "En espera de confirmación":
                $buttonCancel = "<button class='btn btn-cancel' onclick='cancelarCitaAdmin(" . $row['ID'] . ");'>Cancelar</button>"; 
                $buttonConfirm = "<button class='btn btn-confirm' onclick='cargarPersonalModal();' data-bs-toggle='modal' data-bs-target='#asignamientoProfesionalModal'>Confirmar</button>";
                $buttonComplete = "";              
                break;
            case "Confirmada":
                $buttonCancel = "<button class='btn btn-cancel' onclick='cancelarCitaAdmin(" . $row['ID'] . ");'>Cancelar</button>"; 
                $buttonConfirm = "";
                $buttonComplete = " <button class='btn btn-completed'onclick='citaCumplida(" . $row['ID'] . ")'>¿Cumplida?</button>";                  
                break;
            case "Cumplida":
                $buttonCancel = ""; 
                $buttonConfirm = "";
                $buttonComplete = "";   
                break;
            case "Incumplida":
                $buttonCancel = ""; 
                $buttonConfirm = "";
                $buttonComplete = "";   
                break;
            default:
                break;
        }

        echo   "<div class='panel mt-5'>
                    <div class='panel-header'>
                        <h2>" . $row['SERVICIO'] . "</h2>
                    </div>
                    <div class='panel-content'>
                        <p>Fecha: " . $row['FECHA_CITA'] . " Hora: " . $row['HORA_CITA'] . "</p>
                        <p>Estado: " . $row['ESTADO'] . "</p>
                        <h4>" . $pac['NOMBRES'] . " " . $pac['APELLIDOS'] . "</h4>
                        <p>CI: " . $pac['CEDULA'] . "</p>
                        <p>Fecha de nacimiento: " . $pac['FECHA_NACIMIENTO'] . "</p>
                        <p>Telf: " . $pac['TELEFONO'] . "</p>
                    </div>
                    <div class='panel-footer'>".
                    $buttonCancel.
                    $buttonConfirm.
                    $buttonComplete.
                    "</div>
                </div>";
    }
} else {
    echo "Hubo un error al mostrar la cita";
}
?>