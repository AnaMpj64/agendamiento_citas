<?php
require_once('../../models/cls_cita.php');
$obj= new cita();
$result=$obj->cumplidaCita($_POST['id'],$_POST['parametro']);
echo $result;
?>