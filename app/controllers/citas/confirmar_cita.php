<?php
require_once("../../models/cls_cita.php");
require_once("../../models/cls_paciente.php");
require_once("../../models/cls_personal.php");

require '../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCita = $_POST['cita_id_txt'];
    $idProfesional = $_POST['txt_profesional'];

    // Actualizar la cita para asignar el profesional
    $cita = new cita();
    $result = $cita->confirmarCita($idCita, $idProfesional);

    if ($result) {
        // Obtener información del paciente y del profesional asignado
        $paciente = new paciente();
        $personal = new personal();
        $infoCita = $cita->cargarPorCita($idCita); // Obtener la cita
        $rowCita = mysqli_fetch_assoc($infoCita); // Aquí obtenemos la cita correctamente
        $pacienteId = $rowCita['PACIENTE_ID'];

        // Obtener información del paciente
        $infoPacienteResult = $paciente->cargarPorPaciente($pacienteId);
        $infoPaciente = mysqli_fetch_assoc($infoPacienteResult); // Obtenemos los datos del paciente

        // Obtener información del profesional
        $infoProfesionalResult = $personal->cargarPorId($idProfesional);
        $infoProfesional = $infoProfesionalResult; // Obtenemos los datos del profesional

        // Extraer datos del paciente
        $pacienteEmail = $infoPaciente['CORREO'];
        $pacienteNombre = $infoPaciente['NOMBRES'];
        
        // Extraer datos del profesional
        $profesionalNombre = $infoProfesional['NOMBRES'] . " " . $infoProfesional['APELLIDOS'];

        // Enviar el correo al paciente
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor de correo
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host       = 'smtp.gmail.com'; // Configura tu servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'stefansalvw528@gmail.com'; // Email del remitente
            $mail->Password   = 'aafmfjmiruxipkcp'; // Contraseña del remitente
            $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;  
            $mail->Port       = 587;

            // Destinatarios
            $mail->setFrom('stefansalvw528@gmail.com', 'Achilie Fisioterapeuta');
            $mail->addAddress($pacienteEmail, $pacienteNombre);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de cita';
            $mail->Body    = "Estimado(a) $pacienteNombre,<br><br>Su cita ha sido confirmada y se le ha asignado el siguiente profesional: <strong>$profesionalNombre</strong>.<br><br>Le recordamos que puede cancelar su cita máximo con un día de anticipación, para hacerlo debe ir a 'Mi Perfil', elegir la cita y darle clic a cancelar.<br><br>Gracias por confiar en nosotros.";
            $mail->AltBody = "Estimado(a) $pacienteNombre, Su cita ha sido confirmada y se le ha asignado el profesional: $profesionalNombre. Le recordamos que puede cancelar su cita máximo con un día de anticipación, para hacerlo debe ir a 'Mi Perfil', elegir la cita y darle clic a cancelar. Gracias por confiar en nosotros.";

            $mail->send();
            $response['success'] = true;
            $response['message'] = 'Cita confirmada correctamente, y se ha enviado la confirmación al paciente.';
        } catch (Exception $e) {
            $response['message'] = "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        $response['message'] = 'Error al confirmar la cita.';
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>
