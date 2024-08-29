<link href="../../../public/lib/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../../public/lib/jquery.min.js"></script>
<script src="../../../public/lib/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php
require_once('../../models/cls_cita.php');
$objp= new cita();
$result=$objp->agendar(
    $_POST['txt_fecha_cita'],
    $_POST['txt_hora_cita'],
    $_POST['txt_servicio'],
    $_POST['txt_paciente_id']);
if($result)
{
    echo '<script>jQuery(function(){swal({
        title:"Agendamiento correcto", text:"Cita en espera de confirmación", type: "success", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/inicio.php";});});</script>';
}
else
{
    echo '<script>jQuery(function(){swal({
        title:"Agendar Cita", text:"Error al Agendar", type: "danger", confirmButtonText:"Aceptar"
    }, function(){location.href="../../views/inicio.php";});});</script>';
}
?>