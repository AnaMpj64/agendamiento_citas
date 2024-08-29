<link href="../../../public/lib/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../../public/lib/jquery.min.js"></script>
<script src="../../../public/lib/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php
require_once('../../models/cls_cita.php');
$obj= new cita();
$result=$obj->confirmarCita($_POST['cita_id_txt'],
                            $_POST['txt_profesional']);
    if($result)
    {
        echo '<script>jQuery(function(){swal({
        title:"Cita confirmada", text:"Cita confirmada correctamente, se ha asignado un profesional.", type: "success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../views/citas_admin.php";});});</script>';
    }
    else
    {
        echo '<script>jQuery(function(){swal({
        title:"Confirmar Cita", text:"Error al Confirmar", type: "danger", confirmButtonText:"Aceptar"
        }, function(){location.href="../../views/citas_admin.php";});});</script>';
    }
 ?>