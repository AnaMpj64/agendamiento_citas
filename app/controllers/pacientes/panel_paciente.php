<?php

    echo " <div class='panels mt-5' id='form-pac'>
                <div class='panel-header'>
                    <h2>Nuevo Paciente</h2>
                </div>
                <div class='panel-content'>
                    <form action='../controllers/pacientes/insertar_paciente.php' method='POST'>
                        <div class='form-group'>
                            <label for='cedula'>Cedula:</label>
                            <input type='text' id='cedula' name='cedula' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='nombres'>Nombres:</label>
                            <input type='text' id='nombres' name='nombres' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='apellidos'>Apellidos:</label>
                            <input type='text' id='apellidos' name='apellidos' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='fecha_nacimiento'>Fecha de nacimiento:</label>
                            <input type='date' id='fecha_nacimiento' name='fecha_nacimiento' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='correo'>Correo:</label>
                            <input type='email' id='correo' name='correo' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='telefono'>Telefono:</label>
                            <input type='text' id='telefono' name='telefono' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='direccion'>Dirección:</label>
                            <input type='text' id='direccion' name='direccion' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='ocupacion'>Ocupación:</label>
                            <input type='text' id='ocupacion' name='ocupacion' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='alergias'>Alergias:</label>
                            <input type='text' id='alergias' name='alergias' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='antecedentes'>Antecedentes médicos a considerar:</label>
                            <input type='text' id='antecedentes' name='antecedentes' required>
                        </div>
                        <div class='panel-footer'>
                            <button type='submit'>Enviar</button>
                        </div>
                        <br>
                        <br>
                        <br>
                    </form>
                </div>
            </div>";

?>