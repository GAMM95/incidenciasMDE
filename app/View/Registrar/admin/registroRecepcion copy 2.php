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
    global $recepcionRegistrada;
    ?>
    <!-- TODO: TITULO TABLA DE INCIDENCIAS NO RECEPCIONADAS -->
    <div class="flex justify-between items-center mb-2">
      <h1 class="text-xl text-gray-400">Incidencias no recepcionadas</h1>
      <input type="text" id="searchInput" class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-lime-300" placeholder="Buscar..." oninput="filtrarTablaIncidenciasSinRecepcionar()" />
    </div>

    <!-- TODO: TABLA DE INCIDENCIAS NO RECEPCIONADAS -->
    <?php
    require_once './app/Model/IncidenciaModel.php';

    $incidenciaModel = new IncidenciaModel();
    $limit = 2; // Número de filas por página
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
    $start = ($page - 1) * $limit; // Calcula el índice de inicio

    $totalIncidenciasSinRecepcionar = $incidenciaModel->contarIncidenciasSinRecepcionar();
    $totalPages = ceil($totalIncidenciasSinRecepcionar / $limit);

    // Obtiene las incidencias sin recepcionar para la página actual
    $incidencias = $incidenciaModel->obtenerIncidenciasSinRecepcionar($start, $limit);
    ?>

    <div>
      <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
          <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-lime-300">
            <tr>
              <th scope="col" class="px-6 py-3">N°</th>
              <th scope="col" class="px-6 py-3">Fecha y Hora</th>
              <th scope="col" class="px-6 py-3">&Aacute;rea</th>
              <th scope="col" class="px-6 py-3">C&oacute;digo Patrimonial</th>
              <th scope="col" class="px-6 py-3">Categor&iacute;a</th>
              <th scope="col" class="px-6 py-3">Asunto</th>
              <th scope="col" class="px-6 py-3">Usuario</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($incidencias as $incidencia) : ?>
              <tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>
                <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap '><?= $incidencia['INC_numero']; ?></th>
                <td class='px-6 py-4'><?= $incidencia['fechaIncidenciaFormateada']; ?></td>
                <td class='px-6 py-4'><?= $incidencia['ARE_nombre']; ?></td>
                <td class='px-6 py-4'><?= $incidencia['INC_codigoPatrimonial']; ?></td>
                <td class='px-6 py-4'><?= $incidencia['CAT_nombre']; ?></td>
                <td class='px-6 py-4'><?= $incidencia['INC_asunto']; ?></td>
                <td class='px-6 py-4'><?= $incidencia['USU_nombre']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="flex justify-end items-center mt-1">
        <?php if ($page > 1) : ?>
          <a href="#" class="px-4 py-2 bg-gray-200 text-gray-800 hover:bg-gray-300" onclick="changePageTablaSinRecepcionar(<?php echo $page - 1; ?>)">&lt;</a>
        <?php endif; ?>
        <span class="mx-2">P&aacute;gina <?php echo $page; ?> de <?php echo $totalPages; ?></span>
        <?php if ($page < $totalPages) : ?>
          <a href="#" class="px-4 py-2 bg-gray-200 text-gray-800 hover:bg-gray-300" onclick="changePageTablaSinRecepcionar(<?php echo $page + 1; ?>)">&gt;</a>
        <?php endif; ?>
      </div>

      <script src="./app/View/func/func_incidencia_admin.js"></script>
      <script>
        function changePageTablaSinRecepcionar(page) {
          // Realizar la petición AJAX
          fetch(`?page=${page}`)
            .then(response => response.text())
            .then(data => {
              // Actualizar el contenido de la tabla y de la paginación
              const parser = new DOMParser();
              const newDocument = parser.parseFromString(data, 'text/html');
              const newTable = newDocument.querySelector('table');
              const newPagination = newDocument.querySelector('.flex.justify-end.items-center.mt-1');

              // Reemplazar la tabla y la paginación actual
              const currentTable = document.querySelector('table');
              currentTable.parentNode.replaceChild(newTable, currentTable);

              const currentPagination = document.querySelector('.flex.justify-end.items-center.mt-1');
              currentPagination.parentNode.replaceChild(newPagination, currentPagination);
            })
            .catch(error => {
              console.error('Error al cambiar de página:', error);
            });
        }
      </script>
    </div>

    <!-- Segundo Apartado - Formulario de registro de Recepcion de incidencia -->
    <h1 class="text-xl font-bold text-gray-800 mb-2">Recepci&oacute;n de incidencia</h1>
    <!-- TODO: Formulario -->
    <div class="bg-white shadow-md p-4 mb-2 rounded-lg">
      <form id="formRecepcion" action="registro-recepcion-admin.php?action=registrar" method="POST">

        <!-- NUMERO DE INCIDENCIA -->
        <input type="hidden" class="border bg-white p-2 w-full text-sm" id="INC_numero" name="INC_numero">
        <div class="flex justify-center mx-2 mb-2">
          <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center">
            <label for="INC_codigo_visible" class="block font-bold mb-1 mr-3 text-lime-500">N&uacute;mero de Incidencia:</label>
            <input disabled type="text" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" id="INC_codigo_visible" name="INC_codigo_visible" required>
          </div>
        </div>

        <!-- TODO: PRIMERA FILA DEL FORMULARIO -->
        <div class="flex flex-wrap -mx-2 mb-2">
          <!-- INPUT ESCONDIDO PARA EL NUMERO DE RECEPCION -->
          <div class="w-full md:w-1/3 px-2 mb-2 hidden">
            <label for="num_recepcion" class="block font-bold mb-1 ">Num Recepcion:</label>
            <input type="text" id="num_recepcion" name="num_recepcion" class="border p-2 w-full text-sm">
          </div>

          <!-- FECHA DE RECEPCION -->
          <div class="w-full md:w-1/5 px-2 mb-2">
            <label for="fecha_recepcion" class="block font-bold mb-1">Fecha de Recepci&oacute;n:</label>
            <input type="date" id="fecha_recepcion" name="fecha_recepcion" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo date('Y-m-d'); ?>" readonly>
          </div>

          <!-- HORA DE RECEPCION -->
          <div class="w-full md:w-1/5 px-2 mb-2">
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

          <!-- USUARIO QUE REGISTRA LA RECEPCION -->
          <div class="w-full md:w-1/5 px-2 mb-2">
            <label for="usuarioDisplay" class="block font-bold mb-1">Usuario:</label>
            <input type="text" id="usuarioDisplay" name="usuarioDisplay" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['usuario']; ?>" readonly disabled>
          </div>
          <div class="w-full md:w-1/5 px-2 mb-2 hidden">
            <label for="usuario" class="block font-bold mb-1">Usuario:</label>
            <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-sm" value="<?php echo $_SESSION['codigoUsuario']; ?>">
          </div>

          <!-- SELECT PRIORIDAD -->
          <div class="w-full md:w-1/5 px-2 mb-2">
            <label for="prioridad" class="block font-bold mb-1">Prioridad:</label>
            <select id="prioridad" name="prioridad" class="border p-2 w-full text-sm">
              <option value="">Seleccione una prioridad</option>
            </select>
          </div>

          <!-- SELECT IMPACTO -->
          <div class="w-full md:w-1/5 px-2 mb-2">
            <label for="impacto" class="block font-bold mb-1">Impacto:</label>
            <select id="impacto" name="impacto" class="border p-2 w-full text-sm">
              <option value="">Seleccione un impacto</option>
            </select>
          </div>
        </div>

        <!-- TODO: RECOPILACION DE VALORES DE CADA INPUT Y COMBOBOX     -->
        <script>
          document.getElementById('num_recepcion').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_codigo'] : ''; ?>';
          document.getElementById('hora').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_hora'] : $hora_actual; ?>';
          document.getElementById('fecha').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['REC_fecha'] : $fecha_actual; ?>';
          document.getElementById('prioridad').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['PRI_codigo'] : ''; ?>';
          document.getElementById('impacto').value = '<?php echo $recepcionRegistrada ? $recepcionRegistrada['IMP_codigo'] : ''; ?>';
        </script>

        <!-- TODO: BOTONES DE FORMULARIO -->
        <div class="flex justify-center space-x-4">
          <button type="submit" id="guardar-recepcion" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">Guardar</button>
          <button type="button" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">Editar</button>
          <button type="button" id="imprimirDatos" class="bg-yellow-500 text-white font-bold hover:bg-yellow-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Imprimir</button>
          <button type="button" id="limpiarCampos" class="bg-red-500 text-white font-bold hover:bg-red-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Limpiar</button>
          <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">Nuevo</button>
        </div>
      </form>
    </div>

    <!-- TODO: TABLA DE INCIDENCIAS  RECEPCIONADAS -->
    <div>
      <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
          <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-blue-300">
            <tr>
              <th scope="col" class="px-6 py-3">N°</th>
              <th scope="col" class="px-6 py-3">Fecha y Hora</th>
              <th scope="col" class="px-6 py-3">&Aacute;rea</th>
              <th scope="col" class="px-6 py-3">C&oacute;digo Patrimonial</th>
              <th scope="col" class="px-6 py-3">Categor&iacute;a</th>
              <th scope="col" class="px-6 py-3">Prioridad</th>
              <th scope="col" class="px-6 py-3">Impacto</th>
              <th scope="col" class="px-6 py-3">Usuario</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once './app/Model/RecepcionModel.php';
            $recepcionModel = new RecepcionModel();
            $recepciones = $recepcionModel->listarRecepciones();
            foreach ($recepciones as $recepcion) {
              echo "<tr class='second-table bg-white hover:bg-green-100 hover:scale-[101%] transition-all  border-b '>";
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
              echo $recepcion['CAT_nombre'];
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
  </main>

  <script>
    $(document).ready(function() {
      cargarValoresPorDefecto();

      $('tr').click(function() {
        var id = $(this).find('th').html();
        $('tr').removeClass('bg-blue-200 font-semibold');
        $(this).addClass('bg-blue-200 font-semibold');
        $('#INC_numero').val(id);
        $('#INC_codigo_visible').val(id);
      });

      $('#submitButton').click(function() {
        var form = $('form');
        var data = form.serialize();
        console.log(data);
      });

      console.log("FETCHING");
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

      $('#limpiarCampos').click(limpiarCampos);
      $('#nuevoRegistro').click(nuevoRegistro);

      $("#guardar-recepcion").on("click", function() {
        var formData = $("form").serialize();

        $.ajax({
          url: 'registro-recepcion-admin.php' + action,
          type: "POST",
          data: formData,
          success: function(response) {
            if (action === 'registrar') {
              toastr.success('Incidencia registrada');
            } else if (action === 'editar') {
              toastr.success('Incidencia actualizada');
            }
            setTimeout(function() {
              location.reload();
            }, 1500);
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
            toastr.error('Error al guardar persona');
          },
        });
      });

      if (errorMessage) {
        toastr.error(errorMessage);
      }
    });

    function cargarValoresPorDefecto() {
      var prioridadRegistrada = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["PRI_codigo"] : ""; ?>';
      var impactoRegistrado = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["IMP_codigo"] : ""; ?>';

      $.ajax({
        url: 'ajax/getPrioridadData.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          var select = $('#prioridad');
          select.empty();
          select.append('<option value="">Seleccione una prioridad</option>');
          $.each(data, function(index, value) {
            select.append('<option value="' + value.PRI_codigo + '">' + value.PRI_nombre + '</option>');
          });

          if (prioridadRegistrada !== '') {
            select.val(prioridadRegistrada);
          } else {
            select.val('');
          }
        },
        error: function(error) {
          console.error(error);
        }
      });

      $.ajax({
        url: 'ajax/getImpactoData.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          var select = $('#impacto');
          select.empty();
          select.append('<option value="">Seleccione un impacto</option>');
          $.each(data, function(index, value) {
            select.append('<option value="' + value.IMP_codigo + '">' + value.IMP_descripcion + '</option>');
          });

          if (impactoRegistrado !== '') {
            select.val(impactoRegistrado);
          } else {
            select.val('');
          }
        },
        error: function(error) {
          console.error(error);
        }
      });
    }

    function filtrarTablaIncidenciasSinRecepcionar() {
      const input = document.getElementById('searchInput');
      const filter = input.value.toLowerCase();
      const table = document.querySelector('table');
      const rows = table.getElementsByTagName('tr');

      for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let match = false;
        for (let j = 0; j < cells.length; j++) {
          if (cells[j]) {
            if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
              match = true;
              break;
            }
          }
        }
        rows[i].style.display = match ? "" : "none";
      }
    }

    function limpiarCampos() {
      const form = document.getElementById('formRecepcion');
      form.reset();
    }

    function nuevoRegistro() {
      limpiarCampos();
    }
  </script>
</body>

</html>