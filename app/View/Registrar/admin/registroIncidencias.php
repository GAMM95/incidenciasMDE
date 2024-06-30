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

<body class="bg-green-50 flex items-center justify-center min-h-screen">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto rounded-lg shadow-md">
    <?php
    global $incidenciaRegistrada;
    ?>
    <!-- Header -->
    <h1 class="text-xl font-bold mb-4">Registro de Incidencia</h1>
    <!-- Formulario -->
    <form id="formIncidencia" action="registro-incidencia-admin.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex items-center mb-4 hidden">
        <label for="numero_incidencia" class="block font-bold mb-1 mr-1 text-lime-500">Nro Incidencia:</label>
        <input type="text" id="numero_incidencia" name="numero_incidencia" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" readonly disabled>
      </div>

      <div class="flex items-center mb-4 hidden">
        <label for="usuario" class="block font-bold mb-1 mr-1 text-lime-500">Usuario:</label>
        <input type="text" id="usuario" name="usuario" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" readonly disabled>
      </div>

      <!-- SEGUNDA fila: Categoria, Prioridad, Fecha -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="categoria" class="block mb-1 font-bold text-sm">Categor&iacute;a:</label>
          <select id="cbo_categoria" name="categoria" class="border p-2 w-full text-sm cursor-pointer">
          </select>
        </div>
        <!-- Campo de Fecha -->
        <div class="w-full sm:w-1/6 px-2 mb-2">
          <label for="fecha" class="block mb-1 font-bold text-sm">Fecha:</label>
          <input type="date" id="txt_fecha" name="fecha" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>

        <div class="w-full sm:w-1/6 px-2 mb-2">
          <label for="hora" class="block font-bold mb-1">Hora:</label>
          <input type="time" id="txt_hora" name="hora" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" readonly>
        </div>
        <?php
        // Obtener la fecha actual
        date_default_timezone_set('America/Lima');
        $fecha_actual = date('Y-m-d');

        // Obtener la hora actual
        $hora_actual = date('H:i');
        ?>
        <script>
          document.getElementById('numero_incidencia').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_numero'] : ''; ?>';
          document.getElementById('usuario').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['USU_codigo'] : ''; ?>';
          document.getElementById('txt_hora').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_hora'] : $hora_actual; ?>';
          document.getElementById('txt_fecha').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_fecha'] : $fecha_actual; ?>';
        </script>

        <!-- USUARIO -->
        <div class="w-full sm:w-1/6 px-2 mb-2 hidden">
          <label for="usuario" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoUsuario']; ?>">
        </div>
        <div class="w-full sm:w-1/6 px-2 mb-2">
          <label for="usuario" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['usuario']; ?>" readonly disabled>
        </div>
      </div>

      <!-- TERCERA fila: Área, Código Patrimonial -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="area" class="block mb-1 font-bold text-sm">&Aacute;rea:</label>
          <select id="cbo_area" name="area" class="border p-2 w-full text-sm cursor-pointer" title="Seleccione &aacute;rea">
          </select>
        </div>
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="codigo_patrimonial" class="block mb-1 font-bold text-sm">C&oacute;digo Patrimonial:</label>
          <input type="text" id="codigo_patrimonial" name="codigo_patrimonial" class="border p-2 w-full text-sm" maxlength="12" pattern="\d{1,12}" title="Ingrese los 12 d&iacute;gitos del c&oacute;digo patrimonial">
        </div>
      </div>

      <!-- CUARTA fila: Asunto -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="asunto" class="block mb-1 font-bold text-sm">Asunto:</label>
          <input type="text" id="asunto" name="asunto" class="border p-2 w-full text-sm">
        </div>
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <div class="w-full sm:w-1/2 px-2 mb-2">
            <label for="documento" class="block mb-1 font-bold text-sm">Documento:</label>
            <input type="text" id="documento" name="documento" class="border p-2 w-full text-sm" required>
          </div>
        </div>
      </div>

      <script>
        document.getElementById('codigo_patrimonial').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_codigoPatrimonial'] : ''; ?>';
        document.getElementById('cbo_area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['CAT_codigo'] : ''; ?>';
        document.getElementById('asunto').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_asunto'] : ''; ?>';
        document.getElementById('numero_documento').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_documento'] : ''; ?>';
        document.getElementById('area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['ARE_codigo'] : ''; ?>';
      </script>

      <!-- SEXTA fila: Descripción -->
      <div class="w-full mb-2">
        <label for="descripcion" class="block mb-1 font-bold text-sm">Descripci&oacute;n:</label>
        <input type="text" id="descripcion" name="descripcion" class="border p-2 w-full text-sm mb-3">
        <!-- <textarea id="descripcion" name="descripcion" rows="4" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea> -->
      </div>

      <script>
        document.getElementById('descripcion').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['INC_descripcion'] : ''; ?>';
      </script>

      <!-- TODO: BOTONES -->
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
        <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Nuevo
        </button>
      </div>
    </form>
    <!-- Fin del formulario -->

    <!-- TODO: TABLA DE INCIDENCIAS REGISTRADAS -->
    <div>
      <div class="relative max-h-[300px] mt-2 overflow-x-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
          <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-blue-300">
            <tr>
              <th scope="col" class="px-6 py-3">N°</th>
              <th scope="col" class="px-6 py-3">Fecha y Hora</th>
              <th scope="col" class="px-6 py-3">Area</th>
              <th scope="col" class="px-6 py-3">Código Patrimonial</th>
              <th scope="col" class="px-6 py-3">Categoría</th>
              <th scope="col" class="px-6 py-3">Asunto</th>
              <th scope="col" class="px-6 py-3">Usuario</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once './app/Model/IncidenciaModel.php';
            $incidenciaModel = new IncidenciaModel();
            $incidencias = $incidenciaModel->listarIncidencias();
            foreach ($incidencias as $incidencia) {
              echo "<tr class='second-table bg-white hover:bg-green-100 hover:scale-[101%] transition-all  border-b '>";
              echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap '>";
              echo $incidencia['INC_numero'];
              echo "</th>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['fechaIncidenciaFormateada'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['ARE_nombre'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['INC_codigoPatrimonial'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['CAT_nombre'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['INC_asunto'];
              echo "</td>";
              echo "<td class='px-6 py-4'>";
              echo $incidencia['USU_nombre'];
              echo "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script src="./app/View/func/func_incidencias_admin.js"></script>
</body>

</html>