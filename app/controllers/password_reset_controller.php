<?php
require_once('../models/cls_password_reset.php');
require '../../vendor/autoload.php'; // Importa PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];

    // Crear instancia del modelo
    $passwordReset = new PasswordReset();
    
    // Verificar si el correo existe en paciente o personal
    $userInfo = $passwordReset->buscarCorreo($correo);
    
    if ($userInfo) {
        // Generar un código aleatorio alfanumérico de 6 dígitos
        //$codigo = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 6);

        $bytes = random_bytes(6); // 6 bytes = 48 bits de entropía
        $codigo = bin2hex($bytes); // Convertir a hexadecimal
        $codigo = substr($codigo, 0, 6); // Si deseas limitarlo a 6 caracteres

        enviarCorreoCodigo($userInfo['correo'], $userInfo['nombre'], $codigo);

        // Obtener el ID del usuario (paciente o personal) y guardarlo en la tabla de recuperacion_pass
        $usuarioId = $passwordReset->obtenerUsuarioID($correo); // Nueva función para obtener el ID del usuario
        
        // Guardar el código en la tabla recuperacion_pass con AES_ENCRYPT
        $passwordReset->guardarCodigoRecuperacion($usuarioId, $codigo);

        // Responder con éxito
        echo json_encode(['success' => true, 'message' => 'Código enviado al correo']);
    } else {
        // Responder con error si el correo no existe
        echo json_encode(['success' => false, 'message' => 'No hay un usuario registrado con ese correo']);
    }
}

function enviarCorreoCodigo($email, $nombre, $codigo) {
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
        $mail->addAddress($email, $nombre);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Código para cambio de contraseña';
        $mail->Body    = "Estimado(a) $nombre,<br><br>
                          Su código para cambio de contraseña es: <strong>$codigo</strong>.<br>
                          No lo comparta con nadie. El código caducará en 5 minutos.<br><br>
                          Gracias por su atención.";
        $mail->AltBody = "Estimado(a) $nombre, su código para cambio de contraseña es: $codigo. No lo comparta con nadie.";

        $mail->send();
    } catch (Exception $e) {
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}
?>
