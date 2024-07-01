<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body>

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <?php
    global $cierreRegistrado;
    ?>
    <!-- Header -->
    <h1 class="text-xl text-gray-400 mb-2">Incidencias pendientes</h1>
    <!-- Tabla de datos desde la base de datos -->

    <!-- TODO: TABLA DE INCIDENCIAS PENDIENTES -->
    <div>
      <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
          <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-lime-300">
            <tr>
              <th scope="col" class="px-6 py-3">N°</th>
              <th scope="col" class="px-6 py-3">Fecha y Hora</th>
              <th scope="col" class="px-6 py-3">Area</th>
              <th scope="col" class="px-6 py-3">Código Patrimonial</th>
              <th scope="col" class="px-6 py-3">Asunto</th>
              <th scope="col" class="px-6 py-3">Prioridad</th>
              <th scope="col" class="px-6 py-3">Impacto</th>
              <th scope="col" class="px-6 py-3">Usuario</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once './app/Model/RecepcionModel.php';
            $recepcionModel = new RecepcionModel();
            $recepciones = $recepcionModel->obtenerRecepcionesSinCerrar();
            foreach ($recepciones as $recepcion) {
              echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
              echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap '>";
              echo $recepcion['REC_numero'];
              echo "</th>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['fechaRecepcionFormateada'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['ARE_nombre'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['INC_codigoPatrimonial'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['INC_asunto'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['PRI_nombre'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['IMP_descripcion'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $recepcion['USU_nombre'];
              echo "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Segundo Apartado - Formulario de registro de Cierre de incidencia -->
    <h1 class="text-xl font-bold text-gray-800 mt-4 mb-2">Cierre de incidencia</h1>
    <!-- TODO: Formulario -->
    <div class="bg-white shadow-md p-4 mb-2 rounded-lg">
      <form id="formCierre" action="registro-cierre-admin.php?action=registrar" method="POST">

        <!-- NUMERO DE RECEPCION -->
        <input type="hidden" class="border bg-white p-2 w-full text-sm" id="REC_numero" name="REC_numero">
        <div class="flex justify-center mx-2 mb-4">
          <!-- TODO: PRIMERA FILA -->
          <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center">
            <label for="REC_codigo_visible" class="block font-bold mb-1 mr-3 text-lime-500">N&uacute;mero de Recepci&oacute;n:</label>
            <input disabled type="text" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" id="REC_codigo_visible" name="REC_codigo_visible">
          </div>
          <!-- INPUT ESCONDIDO PARA EL NUMERO DE CIERRE -->
          <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center hidden">
            <label for="num_cierre" class="block font-bold mb-1 mr-3 text-lime-500">Num Cierre:</label>
            <input type="text" id="num_cierre" name="num_cierre" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" disabled>
          </div>
        </div>

        <!-- TODO: PRIMERA FILA DEL FORMULARIO -->
        <div class="flex flex-wrap -mx-2">
          <!-- FECHA DE CIERRE -->
          <div class="w-full md:w-1/4 px-2 mb-2">
            <label for="fecha_cierre" class="block font-bold mb-1">Fecha de Cierre:</label>
            <input type="date" id="fecha_cierre" name="fecha_cierre" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo date('Y-m-d'); ?>" readonly>
          </div>

          <!-- HORA DE CIERRE -->
          <div class="w-full md:w-1/4 px-2 mb-2">
            <label for="hora" class="block font-bold mb-1">Hora:</label>
            <?php
            // Establecer la zona horaria deseada
            date_default_timezone_set('America/Lima');
            $fecha_actual = date('Y-m-d');
            // Obtener la hora actual en formato de 24 horas (HH:MM)
            $hora_actual = date('H:i:s');
            ?>
            <input type="text" id="hora" name="hora" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $hora_actual; ?>" readonly>
          </div>

          <!-- USUARIO QUE HARA EL CIERRE -->
          <div class="w-full md:w-1/4 px-2 mb-2">
            <label for="usuarioDisplay" class="block font-bold mb-1">Usuario:</label>
            <input type="text" id="usuarioDisplay" name="usuarioDisplay" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['usuario']; ?>" readonly disabled>
          </div>
          <div class="w-full md:w-1/4 px-2 mb-2 ">
            <label for="usuario" class="block font-bold mb-1">Usuario:</label>
            <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoUsuario']; ?>" readonly disabled>
          </div>

          <!-- OPERATIVIDAD -->
          <div class="w-full md:w-1/4 px-2 mb-2">
            <label for="operatividad" class="block font-bold mb-1">Operatividad:</label>
            <select id="operatividad" name="operatividad" class="border p-2 w-full text-sm cursor-pointer">
            </select>
          </div>
        </div>

        <!-- TODO: SEGUNDA FILA DEL FORMULARIO -->
        <div class="flex flex-wrap -mx-2 ">
          <!-- ASUNTO DEL CIERRE -->
          <div class="w-full md:w-1/3 px-2 mb-2">
            <label for="asunto" class="block mb-1 font-bold text-sm">Asunto:</label>
            <input type="text" id="asunto" name="asunto" class="border p-2 w-full text-sm">
          </div>

          <!-- DOCUMENTO DE CIERRE -->
          <div class="w-full md:w-1/3 px-2 mb-2">
            <label for="documento" class="block mb-1 font-bold text-sm">Documento:</label>
            <input type="text" id="documento" name="documento" class="border p-2 w-full text-sm">
          </div>

          <!-- DIAGNOSTICO DEL CIERRE -->
          <div class="w-full md:w-1/3 px-2 mb-2">
            <label for="diagnostico" class="block mb-1 font-bold text-sm">Diagn&oacute;stico:</label>
            <input type="text" id="diagnostico" name="diagnostico" class="border p-2 w-full text-sm">
          </div>
        </div>

        <!-- TODO: TERCELA FILA DEL FORMULARIO -->
        <div class="flex flex-wrap -mx-2">
          <!-- SOLUCION DE LA INCIDENCIA -->
          <div class="w-full md:w-1/2 px-2 mb-2">
            <label for="solucion" class="block mb-1 font-bold text-sm">Soluci&oacute;n:</label>
            <input type="text" id="solucion" name="solucion" class="border p-2 w-full text-sm">
          </div>

          <!-- RECOMENDACIONES -->
          <div class="w-full md:w-1/2 px-2 mb-2">
            <label for="recomendaciones" class="block mb-1 font-bold text-sm">Recomendaciones:</label>
            <input type="text" id="recomendaciones" name="recomendaciones" class="border p-2 w-full text-sm">
          </div>
        </div>

        <!-- TODO: RECOPILACION DE VALORES DE CADA INPUT Y COMBOBOX     -->
        <script>
          document.getElementById('num_cierre').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['CIE_codigo'] : ''; ?>';
          document.getElementById('fecha').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['CIE_fecha'] : $fecha_actual; ?>';
          document.getElementById('hora').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_hora'] : $hora_actual; ?>';
          document.getElementById('operatividad').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['OPE_codigo'] : ''; ?>';
          document.getElementById('asunto').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_asunto'] : ''; ?>';
          document.getElementById('documento').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_documento'] : ''; ?>';
          document.getElementById('diagnostico').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_diagnostico'] : ''; ?>';
          document.getElementById('solucion').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_solucion'] : ''; ?>';
          document.getElementById('recomendaciones').value = '<?php echo $cierreRegistrado ? $cierreRegistrado['REC_recomendaciones'] : ''; ?>';
        </script>

        <!-- TODO: BOTONES DEL FORMULARIO -->
        <div class="flex justify-center space-x-4 mt-2">
          <button type="submit" id="guardar-cierre" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">Guardar</button>
          <button type="button" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">Editar</button>
          <button type="button" id="imprimirDatos" class="bg-yellow-500 text-white font-bold hover:bg-yellow-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Imprimir</button>
          <button type="button" id="limpiarCampos" class="bg-red-500 text-white font-bold hover:bg-red-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Limpiar</button>
          <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Nuevo</button>
        </div>
      </form>
    </div>
  </main>

  <script src="./app/View/func/func_cierre.js"></script>
</body>

</html>