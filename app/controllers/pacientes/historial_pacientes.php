<?php
require_once("../../models/cls_historial.php");
$historial=new historial();
$result=$historial->cargarPorPaciente($_POST['idPaciente']);
echo "      <button class='btn btn-confirm' onclick='' data-bs-toggle='modal' data-bs-target='#modalActualizarHistorial'>Nuevo</button>
            <div class='row m-4'>
                <table id='tabla' name='tabla' class='table table-bordered rounded'>
                    <thead class='bg-primary text-light text-center'>
                        <th>N.-</th>
                        <th>Fecha</th>
                        <th>Diagnóstico</th>
                        <th>Recomendacion</th>
                        <th>Paciente</th>
                    </thead>
            ";

if(mysqli_num_rows($result)>0)
{
    $f=1;
    while($row=mysqli_fetch_array($result))
    {
        echo "<tr onclick=''>
                <td>".$f."</td>
                <td>".$row['FECHA']."</td>
                <td>".$row['DIAGNOSTICO']."</td>
                <td>".$row['RECOMENDACION']."</td>
                <td>".$row['NOMBRES']." ".$row['APELLIDOS']."</td>
                </tr>";
        $f++;
    }
}
else
{
    echo "<tr><td colspan='5' class='bg-danger text-light text-center'>No existen registros a mostrar</td></tr>";
}
        echo "</table>
        </div>";
?>