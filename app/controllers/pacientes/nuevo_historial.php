<link href="../../../public/lib/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../../public/lib/jquery.min.js"></script>
<script src="../../../public/lib/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php
require_once('../../models/cls_historial.php');
$objp= new historial();
$result=$objp->nuevoHistorial(
    $_POST['diagnostico'],
    $_POST['recomendacion'],
    $_POST['paciente_id'],
    $_POST['resultados'],
    $_POST['txt_servicio'],
    $_POST['txt_profesional']);
if($result)
{
    echo '<script>jQuery(function(){swal({
        title:"Actualización correcta", text:"Se ha añadido una nueva entrada al historial", type: "success", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/pacientes_admin.php";});});</script>';
}
else
{
    echo '<script>jQuery(function(){swal({
        title:"Acrualizar Historial", text:"Error al actualizar el historial", type: "danger", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/pacientes_admin.php";});});</script>';
}
?>