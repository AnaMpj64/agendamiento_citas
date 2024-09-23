const loginBtn = document.querySelector("#login");
const registerBtn = document.querySelector("#register");
const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");

// Cambiar entre las vistas de login y registro
loginBtn.addEventListener('click', () => {
    loginBtn.style.backgroundColor = "#21264D";
    registerBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";

    loginForm.style.left = "50%";
    registerForm.style.left = "-50%";

    loginForm.style.opacity = 1;
    registerForm.style.opacity = 0;

    document.querySelector(".col-1").style.borderRadius = "0 30% 20% 0";
});

registerBtn.addEventListener('click', () => {
    loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
    registerBtn.style.backgroundColor = "#21264D";

    loginForm.style.left = "150%";
    registerForm.style.left = "50%";

    loginForm.style.opacity = 0;
    registerForm.style.opacity = 1;

    document.querySelector(".col-1").style.borderRadius = "0 20% 30% 0";
});

// Validar la contraseña mientras se escribe
document.getElementById('password').addEventListener('input', validatePassword);

function validatePassword() {
    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('passwordError');

    // Expresión regular para validar los requisitos de la contraseña
    const passwordRequirements = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$/;
    
    if (!passwordRequirements.test(password)) {
        passwordError.textContent = 'La contraseña debe tener entre 8 y 16 caracteres, con al menos una mayúscula, una minúscula, un número y un carácter especial.';
        passwordError.style.color = 'red';
    } else {
        passwordError.textContent = '';
    }
}

// Manejar el evento de envío del formulario de registro
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenir el envío por defecto

    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('passwordError');

    // Expresión regular para validar los requisitos de la contraseña
    const passwordRequirements = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,16}$/;

    // Si la contraseña no cumple los requisitos, mostrar el mensaje de error y no permitir el envío
    if (!passwordRequirements.test(password)) {
        passwordError.textContent = 'La contraseña debe tener entre 8 y 16 caracteres, con al menos una mayúscula, una minúscula, un número y un carácter especial.';
        passwordError.style.color = 'red';
        return; // No enviar el formulario si no cumple
    }

    const formData = new FormData(this);

    fetch('app/controllers/registro_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Registro exitoso',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Recargar la página después del registro exitoso
                location.reload(); 
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
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al procesar el registro',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        console.error('Error:', error);
    });
});