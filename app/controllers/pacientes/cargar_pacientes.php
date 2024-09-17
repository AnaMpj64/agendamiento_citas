<?php
require_once("../../models/cls_paciente.php");
$paciente=new paciente();
$result=$paciente->cargarTodosPacientes();
echo " 
    <div class='row m-4'>
        <div class='search-bar'>
            <input type='text' id='buscarInput' onkeyup='buscarTabla()' placeholder='Buscar en la tabla...'>
        </div>
        <div class='table-responsive'>
            <table id='tabla' name='tabla' class='table table-hover table-bordered table-striped rounded'>
                <thead class='bg-primary text-light text-center'>
                    <tr>
                        <th>N.-</th>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>F. Nacimiento</th>
                        <th>Estado Civil</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Telf. Emergencia</th>
                        <th>Dirección</th>
                        <th>Ocupación</th>
                        <th>Alergias</th>
                        <th>Antecedentes</th>
                        <th>Diagnóstico</th>
                        <th>Plan tratamiento</th>
                        <th>Medicación</th>
                        <th>Hábitos</th>
                    </tr>
                </thead>
                <tbody>
            ";

if(mysqli_num_rows($result) > 0) {
    $f = 1;
    while($row = mysqli_fetch_array($result)) {
        echo "<tr class='table-row' onclick='cargarTablaHistorial(" . $row['ID'] . "); idPacienteHistorial(".$row['ID'].");'>
                <td class='text-center'>".$f."</td>
                <td>".$row['CEDULA']."</td>
                <td>".$row['NOMBRES']."</td>
                <td>".$row['APELLIDOS']."</td>
                <td>".$row['FECHA_NACIMIENTO']."</td>
                <td>".$row['ESTADO_CIVIL']."</td>
                <td>".$row['CORREO']."</td>
                <td>".$row['TELEFONO']."</td>
                <td>".$row['CONTACTO_EMERGENCIA']."</td>
                <td>".$row['DIRECCION']."</td>
                <td>".$row['OCUPACION']."</td>
                <td>".$row['ALERGIAS']."</td>
                <td>".$row['ANTECEDENTES']."</td>
                <td>".$row['DIAGNOSTICO']."</td>
                <td>".$row['PLAN_TRATAMIENTO']."</td>
                <td>".$row['MEDICACION']."</td>
                <td>".$row['HABITOS']."</td>
              </tr>";
        $f++;
    }
} else {
    echo "<tr><td colspan='9' class='bg-danger text-light text-center'>No existen registros a mostrar</td></tr>";
}
echo "      </tbody>
            </table>
        </div>
    </div>";
?>
