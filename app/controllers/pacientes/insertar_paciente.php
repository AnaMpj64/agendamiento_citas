<link href="../../../public/lib/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../../public/lib/jquery.min.js"></script>
<script src="../../../public/lib/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php
require_once('../../models/cls_paciente.php');
$objp= new paciente();
$result=$objp->insertar(
    $_POST['cedula'],
    $_POST['nombres'],
    $_POST['apellidos'],
    $_POST['fecha_nacimiento'],
    $_POST['correo'],
    $_POST['telefono'],
    $_POST['ocupacion'],
    $_POST['alergias']);
if($result)
{
    echo '<script>jQuery(function(){swal({
        title:"Guardar paciente", text:"Paciente Guardado", type: "success", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/pacientes_admin.php";});});</script>';
}
else
{
    echo '<script>jQuery(function(){swal({
        title:"Guardar paciente", text:"Error al Guardar", type: "danger", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/pacientes_admin.php";});});</script>';
}
?>