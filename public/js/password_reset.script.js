let countdownInterval;

function sendCode() {
    const email = document.getElementById('email').value;
    const sendCodeBtn = document.getElementById('sendCodeBtn');
    const countdownEl = document.getElementById('countdown');
    const codeBox = document.getElementById('codeBox');  // Capturar el input de código

    // Enviar el correo con el código
    fetch('../../app/controllers/password_reset_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'email=' + encodeURIComponent(email),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Deshabilitar el botón y empezar la cuenta regresiva
            sendCodeBtn.disabled = true;
            startCountdown(30, sendCodeBtn, countdownEl);

            // Mostrar el input para el código de verificación
            codeBox.style.display = 'block';

            // Detectar cuando se ingresa el código y llamar a la función para verificar el código
            document.getElementById('code').addEventListener('input', function() {
                if (this.value.length === 6) {
                    verificarCodigo();  // Verificar el código cuando tiene 6 dígitos
                }
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un problema al enviar el código. Intenta de nuevo.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
}

function startCountdown(seconds, button, countdownEl) {
    let remaining = seconds;
    countdownEl.textContent = `${remaining}s`;
    const interval = setInterval(() => {
        remaining--;
        countdownEl.textContent = `${remaining}s`;
        if (remaining <= 0) {
            clearInterval(interval);
            countdownEl.textContent = '';
            button.disabled = false;
        }
    }, 1000);
}

// Lógica para habilitar el botón de establecer contraseña cuando ambas contraseñas coincidan y cumplan los requisitos
document.getElementById('newPassword').addEventListener('input', validatePasswords);
document.getElementById('repeatPassword').addEventListener('input', validatePasswords);

function validatePasswords() {
    const newPassword = document.getElementById('newPassword').value;
    const repeatPassword = document.getElementById('repeatPassword').value;
    const setPasswordBtn = document.getElementById('setPasswordBtn');
    const setPasswordBox = document.getElementById('setPasswordBox');
    const passwordError = document.getElementById('passwordError');
    const repeatPasswordError = document.getElementById('repeatPasswordError');

    // Resetear mensajes de error
    passwordError.textContent = '';
    repeatPasswordError.textContent = '';

    // Expresión regular para validar los requisitos
    const passwordRequirements = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$/;
    let valid = true;

    if (!passwordRequirements.test(newPassword)) {
        valid = false;
        passwordError.textContent = 'La contraseña debe tener entre 8-16 caracteres, con al menos una mayúscula, una minúscula, un número y un carácter especial.';
    }

    if (newPassword !== repeatPassword) {
        valid = false;
        repeatPasswordError.textContent = 'Las contraseñas no coinciden.';
    }

    // Si todo es válido, habilitar el botón
    if (valid) {
        setPasswordBtn.disabled = false;
        setPasswordBox.style.display = 'block';
    } else {
        setPasswordBtn.disabled = true;
        setPasswordBox.style.display = 'none';
    }
}

function setPassword() {
    const correo = document.getElementById('email').value;
    const newPassword = document.getElementById('newPassword').value;
    const repeatPassword = document.getElementById('repeatPassword').value;

    if (newPassword !== repeatPassword) {
        Swal.fire('Error', 'Las contraseñas no coinciden.', 'error');
        return;
    }

    // Enviar la nueva contraseña al servidor
    fetch('../../app/controllers/update_password_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: correo,
            password: newPassword
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Éxito', 'Contraseña actualizada correctamente', 'success').then(() => {
                window.location.href = '../../index.php'; // Redirecciona al login
            });
        } else {
            Swal.fire('Error', data.message || 'Hubo un problema al actualizar la contraseña.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Hubo un problema al actualizar la contraseña. Intenta de nuevo.', 'error');
    });
}

function verificarCodigo() {
    const codigoIngresado = document.getElementById('code').value;
    const correo = document.getElementById('email').value;

    fetch('../../app/controllers/verificar_codigo_controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: correo, code: codigoIngresado })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Código correcto, mostrar inputs para nueva contraseña
            document.getElementById('newPasswordBox').style.display = 'block';
        } else if (data.error === 'expired') {
            Swal.fire('Código caducado', 'Por favor genere un nuevo código', 'error');
            document.getElementById('newPasswordBox').style.display = 'none'; // Ocultar los inputs si el código está caducado
        } else {
            Swal.fire('Código incorrecto', 'El código ingresado es incorrecto', 'error');
            document.getElementById('newPasswordBox').style.display = 'none'; // Ocultar los inputs si el código es incorrecto
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Hubo un problema al verificar el código. Inténtalo de nuevo.', 'error');
    });
}