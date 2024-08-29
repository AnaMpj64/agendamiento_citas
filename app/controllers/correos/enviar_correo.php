<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destinatario = $_POST["destinatario"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];
    
    $cabeceras = "From: thedarkprincessdd500@gmail.com"; // Cambia esto a tu dirección de correo
    
    // Envía el correo
    if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        echo "Correo enviado con éxito.";
    } else {
        echo "Hubo un problema al enviar el correo.";
    }
}
?>