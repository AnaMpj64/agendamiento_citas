<?php
require_once("../models/cls_conexion.php");
require '../../vendor/autoload.php'; // Importa PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class login{

    public $id;
    public $user;
    public $password;
    public $rol;
    public $paciente_id;
    public $personal_id;

    public function __construct(){
        $this->id = "";
        $this->user = "";
        $this->password = "";
        $this->rol = "";
        $this->paciente_id = "";
        $this->personal_id = "";
    }

    public function verificarCredenciales($user, $password) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
        
        $escapedUser = $conexion->real_escape_string($user);
        
        // Consulta para verificar si el usuario existe y desencriptar la contraseña
        $userCheckSentencia = sprintf(
            "SELECT *, AES_DECRYPT(PASSWORD, 'tu_llave_secreta') AS decrypted_password FROM usuarios WHERE USER = '%s'",
            $escapedUser
        );
        
        // Ejecutar la consulta
        $userCheckResult = mysqli_query($conexion, $userCheckSentencia);
    
        // Verificar si la consulta fue exitosa
        if (!$userCheckResult) {
            // Registrar el error en el log de errores
            error_log("Error en la consulta SQL: " . mysqli_error($conexion));
            return false;
        }
    
        // Verificar si el usuario existe en la base de datos
        if (mysqli_num_rows($userCheckResult) === 1) {
            $userData = mysqli_fetch_assoc($userCheckResult);
    
            // Verificar si la contraseña desencriptada coincide con la ingresada
            if ($userData['decrypted_password'] === $password) {
                // Inicio de sesión exitoso, restablecer intentos a 0
                $resetIntentosSentencia = sprintf(
                    "UPDATE usuarios SET INTENTOS = 0 WHERE USER = '%s'",
                    $escapedUser
                );
                mysqli_query($conexion, $resetIntentosSentencia);
                
                return $userData; // Devuelve el resultado del inicio de sesión exitoso
            } else {
                // Contraseña incorrecta, aumentar INTENTOS si no ha llegado a 3
                if ($userData['INTENTOS'] < 3) {
                    $aumentarIntentosSentencia = sprintf(
                        "UPDATE usuarios SET INTENTOS = INTENTOS + 1 WHERE USER = '%s' AND INTENTOS < 3",
                        $escapedUser
                    );
                    mysqli_query($conexion, $aumentarIntentosSentencia);
                }
    
                // Verificar si los intentos han llegado a 3
                $checkIntentosSentencia = sprintf(
                    "SELECT INTENTOS, ROL, PACIENTE_ID, PERSONAL_ID FROM usuarios WHERE USER = '%s'",
                    $escapedUser
                );
                $checkIntentosResult = mysqli_query($conexion, $checkIntentosSentencia);
                $checkIntentosRow = mysqli_fetch_assoc($checkIntentosResult);
    
                if ($checkIntentosRow['INTENTOS'] == 3) {
                    // Obtener el correo y nombre del paciente o personal dependiendo del rol
                    $correo = "";
                    $nombre = "";
    
                    if ($checkIntentosRow['ROL'] === 'paciente') {
                        // Obtener datos del paciente
                        $pacienteId = $checkIntentosRow['PACIENTE_ID'];
                        $pacienteSentencia = sprintf("SELECT NOMBRES, CORREO FROM paciente WHERE ID = %d", $pacienteId);
                        $pacienteResult = mysqli_query($conexion, $pacienteSentencia);
                        $pacienteData = mysqli_fetch_assoc($pacienteResult);
                        $correo = $pacienteData['CORREO'];
                        $nombre = $pacienteData['NOMBRES'];
                    } elseif ($checkIntentosRow['ROL'] === 'personal') {
                        // Obtener datos del personal
                        $personalId = $checkIntentosRow['PERSONAL_ID'];
                        $personalSentencia = sprintf("SELECT NOMBRES, CORREO FROM personal WHERE ID = %d", $personalId);
                        $personalResult = mysqli_query($conexion, $personalSentencia);
                        $personalData = mysqli_fetch_assoc($personalResult);
                        $correo = $personalData['CORREO'];
                        $nombre = $personalData['NOMBRES'];
                    }
    
                    // Enviar un correo al usuario
                    $this->enviarCorreoAlerta($correo, $nombre);
                }
                
                return false; // Contraseña incorrecta
            }
        } else {
            // Usuario no encontrado
            return false;
        }
    }

    private function enviarCorreoAlerta($email, $nombre) {
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
            $mail->Subject = 'Intentos fallidos de inicio de sesión';
            $mail->Body    = "Estimado(a) $nombre,<br><br>
                              Alguien está intentando acceder a su cuenta. Si no ha sido usted, puede cambiar su contraseña aquí: <a href='https://polar-peak-18328-c36e0d7c1501.herokuapp.com/app/views/password_reset.php'>Cambiar contraseña</a>.<br><br>
                              Gracias por su atención.";
            $mail->AltBody = "Estimado(a) $nombre, Alguien ha intentado acceder a su cuenta. Si no ha sido usted, puede cambiar su contraseña aquí: https://polar-peak-18328-c36e0d7c1501.herokuapp.com/app/views/password_reset.php";

            $mail->send();
        } catch (Exception $e) {
            // Registrar el error si es necesario
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }

    public function actualizarContrasena($userId, $nuevaContrasena) {
        $conex = new DBConexion();
        $conexion = $conex->Conectar();
        
        // Utilizar AES_ENCRYPT para cifrar la nueva contraseña
        $sentencia = sprintf(
            "UPDATE usuarios SET PASSWORD = AES_ENCRYPT('%s', 'tu_llave_secreta') WHERE ID = %d",
            $conexion->real_escape_string($nuevaContrasena),
            $conexion->real_escape_string($userId)
        );
        
        return mysqli_query($conexion, $sentencia);
    }
}

?>
