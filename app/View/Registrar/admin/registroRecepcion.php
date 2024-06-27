<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/assets/logo.ico">

    <!-- Importación de librería jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
        <?php
        global $recepcionRegistrada;
        ?>
        <!-- Header -->
        <h1 class="text-xl font-bold text-gray-800 mb-4">Registro de Recepción</h1>
        <!-- Tabla de datos desde la base de datos -->

        <div>
            <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="sticky
                     top-0 text-xs text-gray-700 uppercase bg-lime-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Num Incidencia
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Código Patrimonial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Categoría
                            </th>
                            <!--<th scope="col" class="px-6 py-3">
                        Prioridad
                    </th>-->
                            <th scope="col" class="px-6 py-3">
                                Fecha Incidencia
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asunto
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once './app/Model/IncidenciaModel.php';
                        $incidenciaModel = new IncidenciaModel();
                        $incidencias = $incidenciaModel->obtenerIncidenciasSinRecepcionar();
                        foreach ($incidencias as $incidencia) {
                            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
                            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap '>";
                            echo $incidencia['INC_numero'];
                            echo "</th>";
                            echo "<td class='px-6 py-4'>";
                            echo $incidencia['INC_codigoPatrimonial'];
                            echo "</td>";
                            echo "<td class='px-6 py-4'>";
                            echo $incidencia['CAT_nombre'];
                            echo "</td>";
                            echo "<td class='px-6 py-4'>";
                            echo $incidencia['INC_fecha'];
                            echo "</td>";
                            echo "<td class='px-6 py-4'>";
                            echo $incidencia['INC_asunto'];
                            echo "</td>";
                            echo "</tr>";
                        }

                        ?>


                    </tbody>
                </table>
            </div>

        </div>


        <!-- Formulario -->
        <div class="bg-white shadow-md p-4 mb-8 mt-8 rounded-lg">
            <form id="formRecepcion" action="registro-recepcion.php?action=registrar" method="POST">
                <input type="hidden" class="border bg-white p-2 w-full text-sm" id="INC_codigo" name="INC_codigo">
                <div class="flex justify-center mx-2 mb-4">
                    <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center">
                        <label for="INC_codigo_visible" class="block font-bold mb-1 mr-1 text-lime-500">Nro
                            Incidencia:</label>
                        <input disabled type="text" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" id="INC_codigo_visible" name="INC_codigo_visible">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-2 mb-2">
                    <div class="w-full md:w-1/3 px-2 mb-2 hidden">
                        <label for="num_recepcion" class="block font-bold mb-1 ">Num Recepcion:</label>
                        <input type="text" id="num_recepcion" name="num_recepcion" class="border p-2 w-full text-sm">
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="fecha_recepcion" class="block font-bold mb-1">Fecha de Recepcion:</label>
                        <input type="date" id="fecha_recepcion" name="fecha_recepcion" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="usuarioDisplay" class="block font-bold mb-1">Usuario:</label>
                        <input type="text" id="usuarioDisplay" name="usuarioDisplay" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['usuario']; ?>">
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4 hidden">
                        <label for="usuario" class="block font-bold mb-1">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoUsuario']; ?>">
                    </div>
                </div>
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
                        <input type="text" id="hora" name="hora" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $horaActual; ?>" readonly>
                    </div>

                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="prioridad" class="block font-bold mb-1">Prioridad:</label>
                        <select id="prioridad" name="prioridad" class="border p-2 w-full text-sm">
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="impacto" class="block font-bold mb-1">Impacto:</label>
                        <select id="impacto" name="impacto" class="border p-2 w-full text-sm">
                        </select>
                    </div>
                </div>
                <script>
                    document.getElementById('num_recepcion').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_codigo'] : ''; ?>';
                    document.getElementById('hora').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_hora'] : $hora_actual; ?>';
                    document.getElementById('fecha').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_fecha'] : $fecha_actual; ?>';
                    document.getElementById('prioridad').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['PRI_codigo'] : ''; ?>';
                    document.getElementById('impacto').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['IMP_codigo'] : ''; ?>';
                </script>



                <!-- Botónes -->
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
    $(document).ready(function() {
        console.log("FETCHING")
        $.ajax({
            url: 'ajax/getPrioridadData.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#prioridad');
                select.empty();
                select.append('<option value="" selected disabled>Seleccione una prioridad</option>');
                $.each(data, function(index, value) {
                    select.append('<option value="' + value.PRI_codigo + '">' + value.PRI_nombre + '</option>');
                });
                document.getElementById('prioridad').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['PRI_codigo'] : ''; ?>';

            },
            error: function(error) {
                console.error(error);
            }
        });
    });
    $(document).ready(function() {
        console.log("FETCHING")
        $.ajax({
            url: 'ajax/getImpactoData.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#impacto');
                select.empty();
                select.append('<option value="" selected disabled>Seleccione nivel de impacto</option>');
                $.each(data, function(index, value) {
                    select.append('<option value="' + value.IMP_codigo + '">' + value.IMP_descripcion + '</option>');
                });
                document.getElementById('impacto').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['IMP_codigo'] : ''; ?>';

            },
            error: function(error) {
                console.error(error);
            }
        });
    });
    // add a listener to every row of the table, so that when it is clicked, it will fill the hidden input with id INC_codigo with the value of the first column of the row
    $(document).ready(function() {
        $('tr').click(function() {
            var id = $(this).find('th').html();
            $('tr').removeClass('bg-blue-200 font-semibold');
            $(this).addClass('bg-blue-200 font-semibold');
            $('#INC_codigo').val(id);
            $('#INC_codigo_visible').val(id);
        });
    });

    $(document).ready(function() {
        $('#submitButton').click(function() {
            var form = $('form');
            var data = form.serialize();
            console.log(data);
        });
    });

    $(document).ready(function() {
        console.log("FETCHING")
        $.ajax({
            url: '../../../ajax/getLastRecepcion.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var input = $('#num_recepcion');
                input.empty();
                input.val(data.REC_codigo);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    function limpiarCampos() {
        // Obtener el formulario por su ID
        const form = document.getElementById('formRecepcion');
        // Limpiar los campos del formulario
        form.reset();
    }
    const btnLimpiar = document.getElementById('limpiarCampos');
    btnLimpiar.addEventListener('click', limpiarCampos);


    function nuevoRegistro() {
        const form = document.getElementById('formRecepcion');

        // Restablecer el formulario
        form.reset();
    }
    // Asignar el evento 'click' al botón 'Nuevo Registro'
    const btnNuevo = document.getElementById('nuevoRegistro');
    btnNuevo.addEventListener('click', nuevoRegistro);
</script>

</html>