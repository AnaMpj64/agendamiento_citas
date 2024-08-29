<?php require_once('../../app/templates/function.php') ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../../app/templates/head.html') ?>
    <title>Administrador</title>
    <link href="../../public/css/dashboard.style.css" rel="stylesheet">
</head>
<body class="g-sidenav-show bg-gray-100">
<?php 
    if(isset($_SESSION['ROL'])){
        if($_SESSION['ROL'] === 'paciente'){ 
            require_once('../../app/templates/navbarUser.php'); 
        } else if($_SESSION['ROL'] === 'Administrador'){
            require_once('../../app/templates/navbarAdmin.php');
        }
    } else {
        header("Location: ../../index.php");
    }
?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php require_once('../../app/templates/aside.php') ?>
            </div>
            <div class="col-md-10">
                <div id="" class="m-2 responsive-iframe-container">
                    <iframe title="Report Section" src="https://app.powerbi.com/view?r=eyJrIjoiODQ2MjM2OTItNTZkNC00MTdkLWEwODgtZWY5ZGY2OTRhMTZiIiwidCI6ImRiNDlmMTcxLTlhZWQtNDQ3Ny1hZmRjLWJjYWIwNjllYjc1YiIsImMiOjR9" 
                        allowFullScreen="true"></iframe>
                </div>
            </div>          
        </div>
    </div>
    
</body>
</html>