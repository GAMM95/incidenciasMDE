<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/assets/logo.ico">

    <!-- Importación de librería jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https:////cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Agrega las hojas de estilo de Tailwind CSS -->
    <link href="http//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Agrega la fuente Poppins desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
    <!-- Implementación de funcionalidades para la vista cliente -->
    <script src="/app/Views/Func/password-toggle.js"></script>
    <!-- Implementación de iconos-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Incluye Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body>

<!-- Contenido principal -->
<main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <h1 class="text-xl font-bold text-gray-800 mb-4">Registro de Cierre </h1>
    <!-- Tabla de datos desde la base de datos -->

    <div>
        <div class="relative max-h-[200px] overflow-x-hidden shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="sticky
                     top-0 text-xs text-gray-700 uppercase bg-lime-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Num Recepcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Código Patrimonial
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Prioridad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Recepcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Impacto
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once './app/models/RecepcionModel.php'; // Asegúrate de tener el modelo correcto para la recepción
                // $recepcionModel = new RecepcionModel();

                try {
                    $recepciones = $recepcionModel->obtenerRecepcionesRegistradas(); // Método para obtener datos de recepción desde la base de datos

                    foreach ($recepciones as $recepcion) {
                        echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
                        echo "<td class='px-6 py-4'>" . $recepcion['NumRecepcion'] . "</td>";
                        echo "<td id='incCodigo' class=' hidden px-6 py-4'>" . $recepcion['NumIncidencia'] . "</td>";
                        echo "<td class='px-6 py-4'>" . $recepcion['codigo_patrimonial'] . "</td>";
                        echo "<td class='px-6 py-4'>" . $recepcion['prioridad'] . "</td>";
                        echo "<td class='px-6 py-4'>" . $recepcion['FechaRecepcion'] . "</td>";
                        echo "<td class='px-6 py-4'>" . $recepcion['impacto'] . "</td>";
                        echo "</tr>";
                    }
                } catch (Exception $e) {
                    // Manejo de la excepción, puedes mostrar un mensaje de error o realizar alguna acción específica
                    echo "Error al obtener las recepciones: " . $e->getMessage();
                }
                ?>



                </tbody>
            </table>
        </div>

    </div>


    <!-- Formulario -->
    <div class="bg-white shadow-md p-4 mb-8 mt-8 rounded-lg">
        <form id="formCierre" action="registro-cierre.php?action=registrar" method="POST">
            <input type="hidden" class="border bg-white p-2 w-full text-sm" id="REC_codigo" name="REC_codigo">
            <div class="flex justify-center mx-2 mb-4">
                <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center">
                    <label for="REC_codigo_visible" class="block font-bold mb-1 mr-1 text-lime-500">Nro
                        Recepción:</label>
                    <input disabled type="text" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm"
                           id="REC_codigo_visible"
                           name="REC_codigo_visible">
                </div>
            </div>

            <!---Fila 2-->
            <div class="flex flex-wrap -mx-2 mb-2">
                <div class="w-full md:w-1/3 px-2 mb-2 hidden">
                    <label for="num_cierre" class="block font-bold mb-1">Num Cierre:</label>
                    <input type="text" id="num_cierre" name="num_cierre" class="border p-2 w-full text-sm" readonly>
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <label for="fecha_cierre" class="block font-bold mb-1">Fecha de Cierre:</label>
                    <input type="date" id="fecha_cierre" name="fecha_cierre"
                           class="border border-gray-200 bg-gray-100 p-2 w-full text-sm"
                           value="<?php echo date('Y-m-d'); ?>" readonly
                    >
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <label for="usuarioDisplay" class="block font-bold mb-1">Usuario:</label>
                    <input type="text" id="usuarioDisplay" name="usuarioDisplay"
                           class="border border-gray-200 bg-gray-100 p-2 w-full text-sm"
                           value="<?php echo $_SESSION['usuario']; ?>">
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4 hidden">
                    <label for="usuario" class="block font-bold mb-1">Usuario:</label>
                    <input type="text" id="usuario" name="usuario"
                           class="border border-gray-200 bg-gray-100 p-2 w-full text-sm"
                           value="<?php echo $_SESSION['codigoUsuario']; ?>">
                </div>
                <!---Fila 2 OPERATIVIDAD-->
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <label for="operatividad" class="block font-bold mb-1">Operatividad:</label>
                    <select id="operatividad" name="operatividad" class="border p-2 w-full text-sm">
                    <option value="Operativo">Operativo</option>
                    <option value="Inoperativo">Inoperativo</option>
                    </select>

                </div>
            </div>
            <!---Fila 3-->

            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <label for="hora" class="block font-bold mb-1">Hora:</label>
                    <?php
                    // Establecer la zona horaria deseada
                    date_default_timezone_set('America/Lima');

                    // Obtener la hora actual en formato de 24 horas (HH:MM)
                    $horaActual = date('H:i');

                    // Mostrar un campo de texto con la hora actual
                    ?>
                    <input type="text" id="hora" name="hora"
                           class="border border-gray-200 bg-gray-100 p-2 w-full text-sm"
                           value="<?php echo $horaActual; ?>" readonly>
                </div>
                <div class="w-full hidden md:w-1/3 px-2 mb-4">
                    <label for="incidencia" class="block font-bold mb-1">Inc:</label>
                    <input type="text" id="incidencia" name="incidencia"
                           class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" readonly>
                </div>

                <div class="w-full md:w-2/3 px-2 mb-4">
                    <label for="documento" class="block font-bold mb-1">Documento:</label>
                    <input type="text" id="documento" name="documento" class="border p-2 w-full text-sm">
                </div>
            </div>

            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full px-2 mb-4">
                    <label for="asunto" class="block font-bold mb-1">Asunto:</label>
                    <textarea id="asunto" name="asunto" rows="3" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea>
                </div>
            </div>
            <!---Fila 4-->
            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full px-2 mb-4">
                    <label for="diagnostico" class="block font-bold mb-1">Diagnostico:</label>
                    <textarea id="diagnostico" name="diagnostico" rows="3" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea>
                </div>
            </div>
            <!-- Fila 5 -->
            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full px-2 mb-4">
                    <label for="solucion" class="block font-bold mb-1">Solución:</label>
                    <textarea id="solucion" name="solucion" rows="4" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea>
                </div>
            </div>

            <!-- Fila 6 -->
            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full px-2 mb-4">
                    <label for="recomendaciones" class="block font-bold mb-1">Recomendaciones:</label>
                    <textarea id="recomendaciones" name="recomendaciones" rows="4" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea>
                </div>
            </div>


            <!-- Botones del formulario -->
            <div class="flex justify-center space-x-4">
                <button type="submit" id="guardar-incidencia" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
                    Guardar
                </button>
                <button type="button" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
                    Editar
                </button>
                <button type="button" id="imprimirDatos" class="bg-yellow-500 text-white font-bold hover:bg-yellow-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
                    Imprimir
                </button>
                <button type="button" id="limpiarCampos" class="bg-red-500 text-white font-bold hover:bg-red-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
                    Limpiar
                </button>
                <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
                    Nuevo
                </button>
            </div>
        </form>
    </div>
</main>

</body>

<script>

    $(document).ready(function () {
        $('tr').click(function () {
            var id = $(this).find('td:first').text();
            var incCodigo = $(this).find('td:nth-child(2)').text();
            //get the value of td with id incCodigo
            var incCodigo = $(this).find('td:nth-child(2)').text();
            $('tr').removeClass('bg-blue-200 font-semibold');
            $(this).addClass('bg-blue-200 font-semibold');
            $('#REC_codigo').val(id);
            $('#REC_codigo_visible').val(id);
            $('#incidencia').val(incCodigo);
        });
    });

    $(document).ready(function () {
        $('#submitButton').click(function () {
            var form = $('form');
            var data = form.serialize();
            console.log(data);
        });
    });

    $(document).ready(function () {
        console.log("FETCHING")
        $.ajax({
            url: '../../../ajax/getLastCierre.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var input = $('#num_cierre');
                input.empty();
                input.val(data.CIE_codigo);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

    function limpiarCampos() {
        // Obtener el formulario por su ID
        const form = document.getElementById('formCierre');
        // Limpiar los campos del formulario
        form.reset();
        $(document).ready(function () {
            console.log("FETCHING")
            $.ajax({
                url: '../../../ajax/getLastCierre.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var input = $('#num_cierre');
                    input.empty();
                    input.val(data.CIE_codigo);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    }
    const btnLimpiar = document.getElementById('limpiarCampos');
    btnLimpiar.addEventListener('click', limpiarCampos);


    function nuevoRegistro() {
        const form = document.getElementById('formCierre');

        // Restablecer el formulario
        form.reset();
    }
    // Asignar el evento 'click' al botón 'Nuevo Registro'
    const btnNuevo = document.getElementById('nuevoRegistro');
    btnNuevo.addEventListener('click', nuevoRegistro);
</script>
</html>