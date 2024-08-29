<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <title>INICIO</title>
    <link href="../../public/css/inicio.style.css" rel="stylesheet">
</head>
<body>
<?php 
    if(isset($_SESSION['ROL'])){
        if($_SESSION['ROL'] === 'paciente'){ 
            require_once('../../app/templates/navbarUser.php'); 
        }else if($_SESSION['ROL'] === 'Administrador'){
            require_once('../../app/templates/navbarAdmin.php');
        }
    } else {
        require_once('../../app/templates/navbarUser.php'); 
    }
?>
    <section class="welcome-section">
            <div class="welcome-slider">
                <!-- Tarjeta 1 -->
                <div class="welcome-card card-1">
                    <h1>Bienvenido a Achilie Fisioterapeuta</h1>
                    <p>Nos dedicamos a proporcionar servicios de fisioterapia de alta calidad con un enfoque integral </br> en la salud física y mental de nuestros pacientes.</p>
                    <p>Con más de 8 años de experiencia, somos tu solución confiable para la rehabilitación y el bienestar.</p>
                </div>
                <!-- Tarjeta 2 -->
                <div class="welcome-card card-2">
                    <h1>Servicios de Excelencia</h1>
                    <p>Ofrecemos una variedad de servicios, desde rehabilitación hasta terapia deportiva y tratamiento de articulaciones.</p>
                    <p>Nuestro objetivo es ayudarte a recuperar tu movilidad y vivir sin limitaciones físicas.</p>
                </div>
                <!-- Tarjeta 3 (Añade más tarjetas según sea necesario) -->
                <div class="welcome-card card-3">
                    <h1>Misión y Visión</h1>
                    <p>Nuestra misión es mejorar la calidad de vida de nuestros pacientes,</br> mientras que nuestra visión es ser líderes en el campo de la fisioterapia.</p>
                    <p>Estamos comprometidos con tu salud y bienestar.</p>
                </div>
            </div>
            <div class="slider-buttons">
                <button id="prevBtn" class="slider-button" onclick="changeSlide(-1)"> < </button>
                <button id="nextBtn" class="slider-button" onclick="changeSlide(1)"> > </button>
            </div>
        </section>
    <div class="container">
        <!-- Sección de Bienvenida -->
        

        <!-- Sección de Servicios -->
        <section class="services-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <!-- Puedes agregar una imagen o ícono para representar cada servicio -->
                        <i class="fas fa-wheelchair fa-3x"></i>
                        <h3>Rehabilitación</h3>
                        <p>Ofrecemos tratamientos efectivos para la rehabilitación y el alivio del dolor.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <i class="fas fa-dumbbell fa-3x"></i>
                        <h3>Terapia Deportiva</h3>
                        <p>Nuestros especialistas están aquí para ayudarte a mantener tu rendimiento físico.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <i class="fas fa-smile fa-3x"></i>
                        <h3>Tratamiento de Articulaciones</h3>
                        <p>Enfocados en mejorar la movilidad y salud de tus articulaciones.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Otras secciones y contenido aquí -->

    </div>
    <script>
    let slideIndex = 0;
    showSlide(slideIndex);

    function changeSlide(n) {
        showSlide(slideIndex += n);
    }

    function showSlide(n) {
        const slides = document.getElementsByClassName("welcome-card");
        if (n >= slides.length) { slideIndex = 0; }
        if (n < 0) { slideIndex = slides.length - 1; }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex].style.display = "block";
    }

    // Cambia automáticamente las diapositivas cada 5 segundos
    setInterval(() => {
        changeSlide(1);
    }, 5000);
</script>

    <!-- Chatbot Script -->
    <script>
    window.embeddedChatbotConfig = {
        chatbotId: "7khDJWI2ZbjhXReo-9ZxM",
        domain: "www.chatbase.co"
    }
    </script>
    <script
    src="https://www.chatbase.co/embed.min.js"
    chatbotId="7khDJWI2ZbjhXReo-9ZxM"
    domain="www.chatbase.co"
    defer>
    </script>
</body>
</html>