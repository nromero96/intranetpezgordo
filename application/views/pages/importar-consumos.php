<!-- Código HTML y CSS -->
<?php $this->load->view('layouts/header'); ?>
<style>
    /* Estilos CSS para el loader y la barra de progreso */
    #loader {
        display: none;
        position: fixed;
        z-index: 999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #progress-bar {
        display: none;
        height: 20px;
        background-color: #f0f0f0;
        margin: 10px auto;
        border-radius: 4px;
        overflow: hidden;
    }

    #progress {
        width: 0%;
        height: 100%;
        background-color: #4CAF50;
        animation: progressAnimation 2s linear;
    }

    /* Animación CSS para la barra de progreso */
    @keyframes progressAnimation {
        from {
            width: 0%;
        }
        to {
            width: 100%;
        }
    }

    /* Estilo para el mensaje de éxito */
    #success-message {
        display: none;
        color: green;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Estilo para el mensaje de error */
    #error-message {
        display: none;
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

</style>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Importar Consumos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulario para enviar el archivo al servidor -->
                    <form id="form_import" method="post" enctype="multipart/form-data">
                        <input type="file" name="archivo" required>
                        <input type="submit" class="btn btn-primary" value="Importar">
                    </form>

                    <!-- Animación de carga y barra de progreso -->
                    <div id="loader">
                        <img src="<?= base_url('assets/img/loading_small.gif'); ?>" alt="Cargando...">
                    </div>
                    <div id="progress-bar">
                        <div id="progress"></div>
                    </div>

                    <!-- Mensaje de éxito -->
                    <div id="success-message">Importación completa.</div>

                    <!-- Mensaje de error -->
                    <div id="error-message">Error al subir el archivo.</div>

                    <br><br>
                    <hr>

                    <!-- mostrar información sobre recomendaciones para importar y descargar la plantilla -->
                    <div>
                        <p>Para importar los usuarios afiliadores, se debe tener en cuenta lo siguiente:</p>
                        <ul>
                            <li>El archivo debe ser de tipo <b>.XLS</b> o <b>.XLSX</b></li>
                            <li>El archivo debe contener los siguientes campos: <strong>Supervisor,	Categoria, Campaña,	Afiliador,	Tipo de QR,	Fecha de Referencia (YYY-MM-DD)</strong>.</li>
                            <li>El archivo <b>no</b> debe contener una fila de encabezado con los nombres de los campos.</li>
                        </ul>
                        <p>Descargar plantilla de ejemplo: <a href="<?= base_url('assets/files/plantilla_consumos.xlsx'); ?>">plantilla_consumos.xlsx</a></p>
                    </div>

                    <br>
                    <hr>
                    <h4>Expotar consumos</h4>
                    <form method="post" action="<?= base_url('ConsumosController/exportar_datos') ?>">
                        <label for="fecha_inicio">Desde:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                        <br>
                        <label for="fecha_fin">Hasta:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary">Exportar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Código JavaScript para manejar la carga del archivo y la barra de progreso -->
<script>
    // Función para realizar la petición AJAX usando una promesa
    function sendAjaxRequest(formData) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();

            // Escuchar el evento "load" para resolver la promesa con éxito
            xhr.addEventListener('load', function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Respuesta exitosa del servidor (código 2xx)
                    resolve(xhr.responseText);
                } else {
                    // Respuesta con error del servidor (código 4xx o 5xx)
                    reject(xhr.statusText);
                }
            });

            // Escuchar el evento "error" para rechazar la promesa en caso de error de red
            xhr.addEventListener('error', function () {
                reject('Error al subir el archivo');
            });

            // Enviar la petición AJAX con los datos del formulario (incluyendo el archivo)
            xhr.open('POST', '<?= base_url('ConsumosController/importar_consumos'); ?>', true);
            xhr.send(formData);
        });
    }

    // Función para ocultar todos los mensajes y el progreso
    function hideAllElements() {
        document.getElementById('success-message').style.display = 'none';
        document.getElementById('error-message').style.display = 'none';
        document.getElementById('loader').style.display = 'none';
        document.getElementById('progress-bar').style.display = 'none';
    }

    // Función para mostrar el progreso de carga
    function showProgressBar() {
        hideAllElements();
        document.getElementById('loader').style.display = 'block';
        document.getElementById('progress-bar').style.display = 'block';
    }

    // Función para mostrar el mensaje de éxito
    function showSuccessMessage() {
        hideAllElements();
        document.getElementById('success-message').style.display = 'block';
    }

    // Función para mostrar el mensaje de error
    function showErrorMessage() {
        hideAllElements();
        document.getElementById('error-message').style.display = 'block';
    }

    // Escuchar el evento "submit" del formulario
    document.getElementById('form_import').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

        // Mostrar el progreso de carga
        showProgressBar();

        // Obtener el formulario y el archivo seleccionado
        var form = event.target;
        var formData = new FormData(form);

        // Llamar a la función para enviar la petición AJAX usando promesas
        sendAjaxRequest(formData)
            .then(function(responseText) {
                // Mostrar el mensaje de éxito
                showSuccessMessage();

                // Resetear el formulario después de 3 segundos
                setTimeout(function() {
                    form.reset();
                }, 3000);
            })
            .catch(function(errorMessage) {
                // Mostrar el mensaje de error
                showErrorMessage();
            })
            .finally(function() {
                // Ocultar el progreso de carga después de 2 segundos
                setTimeout(function() {
                    hideAllElements();
                }, 3000);
            });
    });
</script>

<?php $this->load->view('layouts/footer'); ?>
