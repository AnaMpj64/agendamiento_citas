<?php
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

    $rutaGuardado = '../../public/uploads/';
    
    $nombreArchivo = $_FILES['imagen']['name'];
    
    if(move_uploaded_file($_FILES['imagen']['tmp_name'], '../../../public/uploads/' . $nombreArchivo)) {

        $rutaCompleta = $rutaGuardado . $nombreArchivo;
        require_once('../../models/cls_ejercicio.php');
        $obj= new ejercicio();
        $result=$obj->agregarEjercicio( $_POST['nombre'], $_POST['descripcion'], $rutaCompleta, $_POST['contraindicacion'], $_POST['id_usuario']);
        echo $result;
        
    } else {
        // Respuesta de error
        echo json_encode(array('status' => 'error', 'message' => 'Error al guardar el archivo'));
    }
} else {
    // Respuesta de error
    echo json_encode(array('status' => 'error', 'message' => 'No se proporcionó un archivo'));
}
?>