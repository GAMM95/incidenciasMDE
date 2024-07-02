<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
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
    <!-- TODO: FORMULARIO -->
    <form id="formIncidencia" action="registro-incidencia-user.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">

      <!-- TODO: FILA OCULTA DEL FORMULARIO - NUMERO DE INCIDENCIA -->
      <div class="flex items-center mb-4 ">
        <label for="numero_incidencia" class="block font-bold mb-1 mr-1 text-lime-500">Nro Incidencia:</label>
        <input type="text" id="numero_incidencia" name="numero_incidencia" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" readonly>
      </div>

      <!-- TODO: PRIMERA FILA DEL FORMULARIO -->
      <div class="flex flex-wrap -mx-2">
        <!-- AREA DEL USUARIO -->
        <div class="w-full sm:w-1/6 px-2 mb-2 ">
          <label for="area" class="block mb-1 font-bold text-sm">&Aacute;rea:</label>
          <input type="text" id="area" name="area" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoArea']; ?>" readonly>
        </div>
        <div class="w-full sm:w-1/2 px-2 mb-4">
          <label for="area" class="block font-bold mb-1 text-sm">&Aacute;rea:</label>
          <input type="text" id="area" name="area" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['area']; ?>" readonly>
        </div>


        <!-- FECHA DE REGISTRO DE INCIDENCIA -->
        <div class="w-full sm:w-1/6 px-2 mb-4">
          <label for="fecha" class="block mb-1 font-bold text-sm">Fecha:</label>
          <input type="date" id="fecha" name="fecha" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" readonly>
        </div>

        <!-- HORA DE REGISTRO DE INCIDENCIA -->
        <div class="w-full sm:w-1/6 px-2 mb-4">
          <label for="hora" class="block font-bold mb-1">Hora:</label>
          <input type="time" id="hora" name="hora" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" readonly>
        </div>

        <!-- USUARIO -->
        <!-- codigo del usuario -->
        <div class="w-full sm:w-1/6 px-2 mb-2 ">
          <label for="usuario" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoUsuario']; ?>">
        </div>
        <!-- nombre del usuario -->
        <div class="w-full sm:w-1/6 px-2 mb-4">
          <label for="usuario" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['usuario']; ?>" readonly disabled>
        </div>
      </div>

      <?php
      // Obtener la fecha actual
      date_default_timezone_set('America/Lima');
      $fecha_actual = date('Y-m-d');

      // Obtener la hora actual
      $hora_actual = date('H:i');
      ?>
      <script>
        document.getElementById('numero_incidencia').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['NumIncidencia'] : ''; ?>';
        document.getElementById('hora').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['Hora'] : $hora_actual; ?>';
        document.getElementById('fecha').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['FechaIncidencia'] : $fecha_actual; ?>';
      </script>

      <!-- TODO: SEGUNDA FILA DEL FORMULARIO -->
      <div class="flex flex-wrap -mx-2">
        <!-- Categoria -->
        <div class="w-full md:w-1/3 px-2 mb-4">
          <label for="categoria" class="block mb-1 font-bold text-sm">Categor&iacute;a:</label>
          <select id="categoria" name="categoria" class="border p-2 w-full text-sm cursor-pointer">
          </select>
        </div>
        <!-- Codigo Patrimonial -->
        <div class="w-full md:w-1/3 px-2 mb-4">
          <label for="codigo_patrimonial" class="block mb-1 font-bold text-sm">Código Patrimonial:</label>
          <input type="text" id="codigo_patrimonial" name="codigo_patrimonial" class="border p-2 w-full text-sm" maxlength="12" pattern="\d{1,12}" title="Ingrese los 12 d&iacute;gitos del c&oacute;digo patrimonial">
        </div>

        <!-- ASUNTO DE LA INCIDENCIA -->
        <div class="w-full md:w-1/3 px-2 mb-4">
          <label for="asunto" class="block mb-1 font-bold text-sm">Asunto:</label>
          <input type="text" id="asunto" name="asunto" class="border p-2 w-full text-sm">
        </div>
      </div>

      <!-- TODO: TERCERA FILA DEL FORMULARIO -->
      <div class="flex flex-wrap -mx-2">

        <!-- DOCUMENTO DE LA INCIDENCIA -->
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="documento" class="block mb-1 font-bold text-sm">Documento:</label>
          <input type="text" id="documento" name="documento" class="border p-2 w-full text-sm" required>
        </div>

        <!-- DESCRIPCION DE LA INCIDENCIA -->
        <div class="w-full md:w-2/3 px-2 mb-4">
          <label for="descripcion" class="block mb-1 font-bold text-sm">Descripci&oacute;n:</label>
          <input type="text" id="descripcion" name="descripcion" class="border p-2 w-full text-sm mb-3">
          <!-- <textarea id="descripcion" name="descripcion" rows="4" class="border p-2 w-full text-sm max-h-40 resize-none overflow-y-auto"></textarea> -->
        </div>
      </div>

      <script>
        document.getElementById('codigo_patrimonial').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['CodPatrimonial'] : ''; ?>';
        document.getElementById('asunto').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['Asunto'] : ''; ?>';

        document.getElementById('documento').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['NumDocumento'] : ''; ?>';
        document.getElementById('area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['CodArea'] : ''; ?>';
        document.getElementById('descripcion').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['Descripcion'] : ''; ?>';
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
        <button type="button" id="limpiarCampos" class="bg-red-500 text-white font-bold hover:bg-red-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Limpiar
        </button>
        <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Nuevo
        </button>
      </div>
    </form>
    <!-- Fin del formulario -->
  </main>
</body>
<!-- <script>
  $(document).ready(function() {
    console.log("FETCHING CATEGORIES");
    $.ajax({
      url: 'ajax/getCategoryData.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var select = $('#categoria');
        select.empty();
        $.each(data, function(index, value) {
          console.log(value); // Añade esta línea para depurar y verificar las claves recibidas
          select.append('<option value="' + value.CAT_codigo + '">' + value.CAT_nombre + '</option>');
        });
        // Ajusta la siguiente línea según el uso de PHP en tu entorno
        document.getElementById('categoria').value = '<?php echo isset($incidenciaRegistrada) ? $incidenciaRegistrada["CAT_codigo"] : ""; ?>';
      },
      error: function(error) {
        console.error(error);
      }
    });
  });


  $(document).ready(function() {
    console.log("FETCHING")
    $.ajax({
      url: 'ajax/getAreaData.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var select = $('#area');
        select.empty();
        $.each(data, function(index, value) {
          select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>');
        });
        document.getElementById('area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada['ARE_codigo'] : ''; ?>';
      },
      error: function(error) {
        console.error(error);
      }
    });
  });

  $(document).ready(function() {
    console.log("FETCHING")
    $.ajax({
      url: '../../../ajax/getLastIncidencia.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        var select = $('#numero_incidencia');
        if (select.val() === '') {
          select.empty();
          select.val(data.INC_codigo);
        }
      },
      error: function(error) {
        console.error(error);
      }
    });
  });

  function limpiarCampos() {
    // Obtener el formulario por su ID
    const form = document.getElementById('formIncidencia');
    // Limpiar los campos del formulario
    form.reset();
  }
  const btnLimpiar = document.getElementById('limpiarCampos');
  btnLimpiar.addEventListener('click', limpiarCampos);

  function nuevoRegistro() {
    const form = document.getElementById('formIncidencia');

    // Restablecer el formulario
    form.reset();
  }
  // Asignar el evento 'click' al botón 'Nuevo Registro'
  const btnNuevo = document.getElementById('nuevoRegistro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  //GUARDAR DATOS
  // $(document).ready(function() {
  //   $("#guardar-incidencia").on("click", function() {
  //     // Obtener los datos del formulario
  //     var formData = $("form").serialize(); // Obtener los datos del formulario

  //     $.ajax({
  //       url: "consultar-incidencia.php", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
  //       type: "POST",
  //       data: formData,
  //       success: function(response) {
  //         // Manejar la respuesta del servidor si es necesario
  //         alert("Datos guardados exitosamente");
  //         // Puedes limpiar el formulario si lo deseas
  //         $("form")[0].reset();
  //       },
  //       error: function(xhr, status, error) {
  //         // Manejar los errores si la solicitud falla
  //         console.error(error);
  //         alert("Error al guardar los datos. Por favor, inténtalo de nuevo.");
  //       }
  //     });
  //   });
  // });
</script> -->

</html>