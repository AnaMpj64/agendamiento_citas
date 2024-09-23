<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/password_reset.style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cambio de Contraseña</title>
</head>
<body>
    <div class="form-container">
        <h2>Cambio de Contraseña</h2>
        <div class="form-inputs">
            <div class="input-box">
                <input type="email" class="input-field" id="email" placeholder="Correo electrónico" required>
            </div>
            <div class="input-box">
                <button class="input-submit" id="sendCodeBtn" onclick="sendCode()">Enviar Código</button>
                <span id="countdown"></span>
            </div>
            <div class="input-box" id="codeBox" style="display: none;">
                <input type="text" class="input-field" id="code" placeholder="Ingrese el código" maxlength="6">
            </div>
            <div class="input-box" id="newPasswordBox" style="display: none;">
                <input type="password" class="input-field" id="newPassword" placeholder="Nueva contraseña">
                <p id="passwordError" class="error-message"></p> <!-- Mensaje de error -->
                <input type="password" class="input-field" id="repeatPassword" placeholder="Repita la contraseña">
                <p id="repeatPasswordError" class="error-message"></p> <!-- Mensaje de error -->
            </div>
            <!-- Botón para establecer nueva contraseña -->
            <div class="input-box" id="setPasswordBox" style="display: none;">
                <button class="input-submit" id="setPasswordBtn" onclick="setPassword()" disabled>Establecer Contraseña</button>
            </div>
        </div>
    </div>
    <script src="../../public/js/password_reset.script.js"></script>
</body>
</html>