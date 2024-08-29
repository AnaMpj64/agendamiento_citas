<?php

    echo " <div class='panels mt-5' id='form-pac'>
                <div class='panel-header'>
                    <h2>Enviar Correo</h2>
                </div>
                <div class='panel-content'>
                    <form action='../controllers/correos/enviar_correo.php' method='POST'>
                        <div class='form-group'>
                            <label for='destinatario'>Destinatario:</label>
                            <input type='email' id='destinatario' name='destinatario' required>
                        </div>
                        <div class='form-group mt-2'>
                            <label for='asunto'>Asunto:</label>
                            <input type='text' id='asunto' name='asunto' required>
                        </div>
                        <div class='form-group'>
                            <label for='mensaje'>Mensaje:</label>
                            <textarea id='mensaje' name='mensaje' rows='4' required></textarea>
                        </div>
                        <div class='panel-footer'>
                            <button type='submit'>Enviar</button>
                        </div>
                    </form>
                </div>
            </div>";

?>