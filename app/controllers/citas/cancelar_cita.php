<?php
require_once('../../models/cls_cita.php');
$obj= new cita();
$result=$obj->cancelarCita($_POST['id']);
echo $result;
?>