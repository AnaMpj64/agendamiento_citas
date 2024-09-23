<?php
require_once('../models/cls_conexion.php');
require_once('../models/cls_login.php');  // Archivo del login
require '../../vendor/autoload.php'; // PHPMailer si se necesita para enviar correos de confirmación

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['email'];   // Obtener el correo del formulario de registro
    $user = $_POST['user'];      // Nombre de usuario (USER)
    $password = $_POST['password'];  // Contraseña

    // Crear una conexión a la base de datos
    $conex = new DBConexion();
    $conexion = $conex->Conectar();

    // Buscar el correo en la tabla paciente
    $queryPaciente = sprintf("SELECT ID FROM paciente WHERE CORREO = '%s'", $conexion->real_escape_string($correo));
    $resultPaciente = mysqli_query($conexion, $queryPaciente);

    // Buscar el correo en la tabla personal
    $queryPersonal = sprintf("SELECT ID FROM personal WHERE CORREO = '%s'", $conexion->real_escape_string($correo));
    $resultPersonal = mysqli_query($conexion, $queryPersonal);

    // Verificar si el correo pertenece a un paciente
    if (mysqli_num_rows($resultPaciente) > 0) {
        $rowPaciente = mysqli_fetch_assoc($resultPaciente);
        $pacienteId = $rowPaciente['ID'];

        // Verificar si ya existe un usuario registrado con este ID de paciente
        $queryUsuario = sprintf("SELECT * FROM usuarios WHERE PACIENTE_ID = %d", $pacienteId);
        $resultUsuario = mysqli_query($conexion, $queryUsuario);

        if (mysqli_num_rows($resultUsuario) > 0) {
            // Ya existe un usuario con este ID de paciente
            echo json_encode(['success' => false, 'message' => 'Correo ya registrado como paciente']);
            exit();
        }

        $rol = 'paciente';
        $personalId = 'NULL';  // No es administrador

    } elseif (mysqli_num_rows($resultPersonal) > 0) {
        $rowPersonal = mysqli_fetch_assoc($resultPersonal);
        $personalId = $rowPersonal['ID'];

        // Verificar si ya existe un usuario registrado con este ID de personal
        $queryUsuario = sprintf("SELECT * FROM usuarios WHERE PERSONAL_ID = %d", $personalId);
        $resultUsuario = mysqli_query($conexion, $queryUsuario);

        if (mysqli_num_rows($resultUsuario) > 0) {
            // Ya existe un usuario con este ID de personal
            echo json_encode(['success' => false, 'message' => 'Correo ya registrado como Administrador']);
            exit();
        }

        $rol = 'Administrador';
        $pacienteId = 'NULL';  // No es paciente

    } else {
        // El correo no se encuentra ni en pacientes ni en personal
        echo json_encode(['success' => false, 'message' => 'El correo no está registrado en nuestra base de datos']);
        exit();
    }

    // Encriptar la contraseña usando AES_ENCRYPT
    $passwordEncriptada = sprintf("AES_ENCRYPT('%s', 'tu_llave_secreta')", $conexion->real_escape_string($password));

    // Insertar el nuevo usuario
    $insertUsuario = sprintf(
        "INSERT INTO usuarios (USER, PASSWORD, ROL, PACIENTE_ID, PERSONAL_ID, INTENTOS) 
        VALUES ('%s', %s, '%s', %s, %s, 0)",
        $conexion->real_escape_string($user),
        $passwordEncriptada,
        $rol,
        $pacienteId,
        $personalId
    );
    
    $resultInsert = mysqli_query($conexion, $insertUsuario);

    if ($resultInsert) {
        echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
    }
}
?>