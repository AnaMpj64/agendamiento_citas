<?php
require_once('../../models/cls_cita.php');
require_once('../../models/cls_paciente.php');
require_once('../../models/cls_personal.php');

// Importar PHPMailer
require '../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$obj = new cita();
$result = $obj->cancelarCita($_POST['id']);

if ($result) {
    // Obtener la información del paciente relacionada con la cita cancelada
    $cita = new cita();
    $infoCita = $cita->cargarPorCita($_POST['id']);
    $rowCita = mysqli_fetch_assoc($infoCita); // Obtener la cita cancelada

    // Obtener información del paciente
    $paciente = new paciente();
    $pacienteId = $rowCita['PACIENTE_ID'];
    $infoPacienteResult = $paciente->cargarPorPaciente($pacienteId);
    $infoPaciente = mysqli_fetch_assoc($infoPacienteResult);

    // Extraer datos del paciente
    $pacienteEmail = $infoPaciente['CORREO'];
    $pacienteNombre = $infoPaciente['NOMBRES'];

    // Enviar el correo al paciente
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com'; // Configura tu servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'stefansalvw528@gmail.com'; // Cambia esto por tu correo
        $mail->Password   = 'aafmfjmiruxipkcp'; // Cambia esto por tu contraseña de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinatarios
        $mail->setFrom('stefansalvw528@gmail.com', 'Achilie Fisioterapeuta');
        $mail->addAddress($pacienteEmail, $pacienteNombre);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Cancelación de su Cita';
        $mail->Body    = "Estimado(a) $pacienteNombre,<br><br>
                  Esperamos que este mensaje le encuentre bien. Lamentamos informarle que, debido a motivos personales, 
                  hemos tenido que cancelar su cita programada para el <strong>{$rowCita['FECHA_CITA']} a las {$rowCita['HORA_CITA']}.</strong><br><br>
                  Entendemos que esto puede ser inconveniente y le pedimos disculpas por cualquier molestia que esto pueda causar.<br><br>
                  Reagendaremos su cita a través de nuestra plataforma, también puede ponerse en contacto con nosotros para encontrar un nuevo horario que se ajuste a sus necesidades.<br><br>
                  Agradecemos su comprensión y estamos aquí para asistirle en lo que necesite.";
                  
        $mail->AltBody = "Estimado(a) $pacienteNombre,\n\n
                 Esperamos que este mensaje le encuentre bien. Lamentamos informarle que, debido a motivos personales, 
                 hemos tenido que cancelar su cita programada para el {$rowCita['FECHA_CITA']} a las {$rowCita['HORA_CITA']}.\n\n
                 Entendemos que esto puede ser inconveniente y le pedimos disculpas por cualquier molestia que esto pueda causar.\n\n
                 Reagendaremos su cita a través de nuestra plataforma, también puede ponerse en contacto con nosotros para encontrar un nuevo horario que se ajuste a sus necesidades.\n\n
                 Agradecemos su comprensión y estamos aquí para asistirle en lo que necesite.";

        $mail->send();
        echo 'Correo enviado'; // Responder con éxito si el correo se envió
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    // Responder con error si algo falló
    echo 'Error al cancelar cita';
}
