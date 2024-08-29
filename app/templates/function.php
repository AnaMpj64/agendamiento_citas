<?php
session_start();
$paciente_id = ''; 

if (isset($_SESSION['PACIENTE_ID'])) {
    $paciente_id = $_SESSION['PACIENTE_ID'];

} elseif (isset($_SESSION['PERSONAL_ID'])) {
    $personal_id = $_SESSION['PERSONAL_ID'];
}
?>