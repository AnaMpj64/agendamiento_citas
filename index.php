<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="public/img/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Achilie Fisioterapeuta</title>
    <!-- BOXICONS -->
    <link href='public/lib/boxicons/css/boxicons.min.css' rel='stylesheet'>
    <!-- STYLE -->
    <link rel="stylesheet" href="public/css/index.style.css">
</head>
<body>
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="public/img/white-outline.png" class="form-image-main">
                <img src="public/img/dots.png" class="form-image dots">
                <img src="public/img/coin.png" class="form-image coin">
                <img src="public/img/spring.png" class="form-image spring">
                <img src="public/img/doctor.png" class="form-image rocket">
                <img src="public/img/cloud.png" class="form-image cloud">
                <img src="public/img/stars.png" class="form-image stars">
            </div>
            <p class="featured-words">Bienvenido a su consultorio fisioterapeutico de confianza <span>Achilie Fisioterapeuta</span></p>
        </div>

        <div class="col col-2">
            <div class="btn-box">
                <button class="btn btn-1" id="login">Ingresar</button>
                <button class="btn btn-2" id="register">Registrarse</button>
            </div>

            <!-- Login Form Container -->
            <div class="login-form">
                <div class="form-title">
                    <img src="public/img/logo_name.png" alt="Logo" class="form-title-logo">
                    <span>Iniciar</span>
                </div>
                <div class="form-inputs">
                    <form action="app/controllers/login_controller.php" method="post" class="login">
                        <div class="input-box">
                            <input type="text" class="input-field" id="user" name="user" placeholder="Usuario" required>
                            <i class="bx bx-user icon"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" id="pass" name="pass" placeholder="Contraseña" required>
                            <!--<i class="bx bx-lock-alt icon"></i> -->
                        </div>
                        <div class="forgot-pass">
                            <a href="app/views/password_reset.php">Olvidé la contraseña</a>
                        </div>
                        <div class="input-box">
                            <button type="submit" class="input-submit">
                                <span>Ingresar</span>
                                <i class="bx bx-right-arrow-alt"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="social-login">
                    <a href="https://wa.me/593990392540"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>

            <!-- Register Form Container -->
            <div class="register-form">
                <div class="form-title">
                    <span>Crear cuenta</span>
                </div>
                <div class="form-inputs">
                    <form id="registerForm">
                        <div class="input-box">
                            <input type="text" class="input-field" id="email" name="email" placeholder="Correo" required>
                            <i class="bx bx-envelope icon"></i>
                        </div>
                        <div class="input-box">
                            <!-- Cambiar id de "user" a "registerUser" -->
                            <input type="text" class="input-field" id="registerUser" name="user" placeholder="Usuario" required>
                            <i class="bx bx-user icon"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" id="password" name="password" placeholder="Contraseña" required>
                            <span id="passwordError"></span>
                            <!--<i class="bx bx-lock-alt icon"></i> -->
                        </div>
                        <div class="input-box">
                            <button type="submit" class="input-submit">
                                <span>Registrarse</span>
                                <i class="bx bx-right-arrow-alt"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="social-login">
                    <i class="bx bxl-whatsapp"></i>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/index.script.js"></script>
</body>
</html>

