<div class="pcoded-main-container mt-5">
  <div class="pcoded-content">

    <!-- Inicio de breadcrumb -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h1 class="text-2xl font-bold mb-2">Cierre de incidencias</h1>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href=""><i class="feather icon-edit"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Registros</a></li>
              <li class="breadcrumb-item"><a href="">Cierres</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin de breadcrumb -->

    <!-- Titulo de recepciones y paginador -->
    <div id="noRecepcion" class="flex justify-between items-center mb-2">
      <h1 class="text-xl text-gray-400">Incidencias pendientes para cierre</h1>
      <div id="paginadorRecepcionesSinCerrar" class="flex justify-end items-center mt-1">
        <!-- Paginación aquí -->
        <?php if ($totalPages > 1) : ?>
          <?php if ($page > 1) : ?>
            <a href="#" class="px-2 py-1 bg-gray-400 text-gray-200 hover:bg-gray-600 rounded-l-md" onclick="changePageTablaSinCerrar(<?php echo $page - 1; ?>)"><i class="feather mr-2 icon-chevrons-left"></i> Anterior</a>
          <?php endif; ?>
          <span class="px-2 py-1 bg-gray-400 text-gray-200"><?php echo $page; ?> de <?php echo $totalPages; ?></span>
          <?php if ($page < $totalPages) : ?>
            <a href="#" class="px-2 py-1 bg-gray-400 text-gray-200 hover:bg-gray-600 rounded-r-md" onclick="changePageTablaSinCerrar(<?php echo $page + 1; ?>)"> Siguiente <i class="feather ml-2 icon-chevrons-right"></i></a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    <!-- final de paginador -->

    <!-- Tabla de recepciones sin cerrar -->
    <input type="hidden" id="recepcionCount" value="<?php echo count($recepciones); ?>">
    <div class="mb-4">
      <div id="tablaContainer" class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
        <table id="tablaRecepcionesSinCerrar" class="w-full text-xs text-left rtl:text-right text-gray-500 bg-white">
          <!-- Encabezado de la tabla -->
          <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-lime-300">
            <tr>
              <th scope="col" class="px-6 py-2 text-center hidden">N&deg; mantenimiento</th>
              <th scope="col" class="px-6 py-2 text-center hidden">N&deg; inc</th>
              <th scope="col" class="px-6 py-2 text-center">INCIDENCIA</th>
              <th scope="col" class="px-6 py-2 text-center">Fecha recepci&oacute;n</th>
              <th scope="col" class="px-6 py-2 text-center">&Aacute;rea</th>
              <th scope="col" class="px-6 py-2 text-center">C&oacute;digo Patrimonial</th>
              <th scope="col" class="px-6 py-2 text-center">NOMBRE BIEN</th>
              <th scope="col" class="px-6 py-2 text-center">Asunto</th>
              <th scope="col" class="px-6 py-2 text-center">Documento</th>
              <th scope="col" class="px-6 py-2 text-center">Usuario Soporte</th>
            </tr>
          </thead>
          <!-- Fin de encabezado -->

          <!-- Cuerpo de la tabla -->
          <tbody>
            <?php foreach ($recepciones as $recepcion) : ?>
              <tr class='hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>
                <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap hidden'><?= $recepcion['MAN_codigo']; ?></th>
                <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap hidden'><?= $recepcion['INC_numero']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['INC_numero_formato']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['fechaRecepcionFormateada']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['ARE_nombre']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['INC_codigoPatrimonial']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['BIE_nombre']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['INC_asunto']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['INC_documento']; ?></th>
                <td class='px-6 py-2 text-center'><?= $recepcion['usuarioSoporte']; ?></th>
              </tr>
            <?php endforeach; ?>

            <?php if (empty($recepciones)) : ?>
              <tr>
                <td colspan="8" class="text-center py-4">No hay incidencias recepionadas sin cerrar.</td>
              </tr>
            <?php endif; ?>
          </tbody>
          <!-- Fin de cuerpo de la tabla -->
        </table>
      </div>
    </div>
    <!-- Fin de tabla de recepciones sin cerrar -->

    <!-- Formulario de registro de cierres -->
    <form id="formCierre" action="registro-cierre.php?action=registrar" method="POST" class="card table-card  bg-white shadow-md p-6 w-full text-xs mb-2">
      <input type="hidden" id="form-action" name="action" value="registrar">

      <!-- NUMERO DE RECEPCION -->
      <div class="flex justify-center mx-2 mb-4">
        <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center hidden ">
          <label for="num_incidencia" class="block font-bold mb-1 mr-3 text-lime-500">N&uacute;mero de Incidencia:</label>
          <input type="text" id="num_incidencia" name="num_incidencia" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
        </div>

        <!-- INCIDENCIA SELECCIONADA -->
        <div class="flex justify-center items-center mr-5 ml-5">
          <div class="text-center">
            <label for="incidenciaSeleccionada" class="block font-bold mb-1 text-[#32cfad]">Incidencia seleccionada:</label>
            <input type="text" class="border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center w-full" id="incidenciaSeleccionada" name="incidenciaSeleccionada" readonly required>
          </div>
        </div>

        <!-- Numero de mantenimiento -->
        <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center hidden">
          <label for="mantenimiento" class="block font-bold mb-1 mr-3 text-lime-500">N&uacute;mero de Mantenimiento:</label>
          <input type="text" id="mantenimiento" name="mantenimiento" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
        </div>

        <!-- INPUT ESCONDIDO PARA EL NUMERO DE CIERRE -->
        <div class="flex-1 max-w-[500px] px-2 mb-2 flex items-center hidden">
          <label for="num_cierre" class="block font-bold mb-1 mr-3 text-lime-500">N&uacute;mero Cierre:</label>
          <input type="text" id="num_cierre" name="num_cierre" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
        </div>
      </div>

      <!-- PRIMERA FILA DEL FORMULARIO -->
      <div class="flex flex-wrap -mx-2">

        <!-- Fecha de cierre -->
        <div class="w-full md:w-1/4 px-2 mb-2 hidden">
          <label for="fecha_cierre" class="block font-bold mb-1">Fecha de Cierre:</label>
          <input type="date" id="fecha_cierre" name="fecha_cierre" class="border border-gray-200 bg-gray-100 p-2 w-full text-xs" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>
        <!-- Fin de fecha de cierre -->

        <!-- Hora de cierre -->
        <div class="w-full md:w-1/4 px-2 mb-2 hidden">
          <label for="hora" class="block font-bold mb-1">Hora:</label>
          <?php
          // Establecer la zona horaria deseada
          date_default_timezone_set('America/Lima');
          $fecha_actual = date('Y-m-d');
          // Obtener la hora actual en formato de 24 horas (HH:MM)
          $hora_actual = date('H:i:s');
          ?>
          <input type="text" id="hora" name="hora" class="border border-gray-200 bg-gray-100 p-2 w-full text-xs" value="<?php echo $hora_actual; ?>" readonly>
        </div>
        <!-- fin de hora de cierre -->

        <!-- Usuario que realiza el cierre -->
        <div class="w-full md:w-1/4 px-2 mb-2 hidden">
          <label for="usuarioDisplay" class="block font-bold mb-1">Usuario:</label>
          <input type="text" id="usuarioDisplay" name="usuarioDisplay" class="border border-gray-200 bg-gray-100 p-2 w-full text-xs" value="<?php echo $_SESSION['usuario']; ?>" readonly>
        </div>
        <div class="w-full md:w-1/4 px-2 mb-2 hidden">
          <label for="usuario" class="block font-bold mb-1">Usuario:</label>
          <input type="text" id="usuario" name="usuario" class="border border-gray-200 bg-gray-100 p-2 w-full text-xs" value="<?php echo $_SESSION['codigoUsuario']; ?>" readonly>
        </div>
        <!-- Fin de usuario que realiza el cierre -->

        <!-- Documento de cierre -->
        <div class="w-full md:w-2/5 px-2 mb-2">
          <label for="documento" class="block mb-1 font-bold text-xs">Documento de cierre: *</label>
          <input type="text" id="documento" name="documento" class="border p-2 w-full text-xs rounded-md" placeholder="Ingrese documento de cierre" oninput="uppercaseInput(this)">
        </div>
        <!-- Fin de documento de cierre -->

        <!-- Operatividad del cierre -->
        <div class="w-full md:w-1/5 px-2 mb-2">
          <label for="operatividad" class="block font-bold mb-1 text-xs">Condici&oacute;n: *</label>
          <select id="operatividad" name="operatividad" class="border p-2 w-full text-xs cursor-pointer rounded-md">
          </select>
        </div>
        <!-- Fin de operatividad de cierre -->

        <!-- Solucion del cierre -->
        <div class="w-full md:w-2/5 px-2 mb-2 flex items-end">
          <div class="w-full">
            <label for="solucion" class="block font-bold mb-1 text-xs">Soluci&oacute;n: *</label>
            <select id="solucion" name="solucion" class="border p-2 w-full text-xs cursor-pointer rounded-md">
            </select>
          </div>

          <!-- Botón al costado del select -->
          <a href="modulo-solucion.php"
            class="ml-2 bn btn-warning text-xs text-white font-bold h-9 py-2 px-3 rounded-md flex items-center hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400"
            title="Agregar nueva soluci&oacute;n"
            aria-label="Agregar nueva soluci&oacute;n">
            <i class="feather icon-plus"></i>
          </a>

        </div>
        <!-- Fin de solucion de cierre con botón al costado -->
      </div>
      <!-- Fin de primera fila del formulario -->

      <!-- Segundo fila de formulario -->
      <div class="flex flex-wrap -mx-2">
        <!-- Diagnostico y observaciones del cierre -->
        <div class="w-1/2 px-2 mb-2">
          <label for="diagnostico" class="block mb-1 font-bold text-xs">Diagn&oacute;stico / observaciones:</label>
          <textarea id="diagnostico" name="diagnostico" rows="3" class="border p-2 w-full text-xs rounded-md" placeholder="Ingrese diagnóstico (opcional)" style="resize: none;" maxlength="1000" oninput="updateCharCount('diagnostico', 'charCount1')" oninput="capitalizeInput(this)"></textarea>
          <p id="charCount1" class="text-xs text-gray-500">0/1000 caracteres</p>
        </div>
        <!-- Fin del diagnostico y observaciones -->

        <!-- Recomendaciones del cierre -->
        <div class="w-1/2 md:w-1/1 px-2 mb-2">
          <label for="recomendaciones" class="block mb-1 font-bold text-xs">Recomendaciones:</label>
          <textarea id="recomendaciones" name="recomendaciones" rows="3" class="border p-2 w-full text-xs rounded-md" placeholder="Ingrese recomendaciones (opcional)" style="resize: none;" maxlength="1000" oninput="updateCharCount('recomendaciones', 'charCount2')" oninput="capitalizeInput(this)"></textarea>
          <p id="charCount2" class="text-xs text-gray-500">0/1000 caracteres</p>
        </div>
        <!-- Fin de recomendaciones del cierre -->
      </div>
      <!-- Fin de segunda fila de formulario -->

      <!-- Botones del formulario -->
      <div class="flex justify-center space-x-4">
        <button type="submit" id="guardar-cierre" class="bn btn-primary text-xs text-white font-bold py-2 px-3 rounded-md disabled:bg-gray-300 disabled:cursor-not-allowed"><i class="feather mr-2 icon-save"></i>Cerrar</button>
        <?php if ($rol === 'Administrador') : ?> <!-- Botón "Actualizar" visible solo para Administradores -->
          <button type="button" id="editar-cierre" class="bn btn-info text-xs text-white font-bold py-2 px-3 rounded-md disabled:bg-gray-300 disabled:cursor-not-allowed" disabled><i class="feather mr-2 icon-edit"></i>Actualizar</button>
        <?php endif; ?>
        <button type="button" id="nuevo-registro" class="bn btn-secondary text-xs text-white font-bold py-2 px-3 rounded-md"> <i class="feather mr-2 icon-plus-square"></i>Limpiar</button>
      </div>
      <!-- Fin de botones -->
    </form>
    <!-- Fin de formulario -->

    <!-- Titulo y paginacion de tabla de recepciones -->
    <div class="flex justify-between items-center mb-2">
      <h1 class="text-xl text-gray-400">Lista de incidencias cerradas</h1>
    </div>

    <!-- Tabla de incidencias cerradas -->
    <div class="relative max-h-[400px] mt-2 overflow-x-hidden shadow-md sm:rounded-lg">
      <table id="tablaIncidenciasCerradas" class="w-full text-xs text-left rtl:text-right text-gray-500 cursor-pointer bg-white">
        <!-- Encabezado de la tabla -->
        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-blue-300">
          <tr>
            <th scope="col" class="px-6 py-2 text-center hidden">num Cierre</th>
            <th scope="col" class="px-6 py-2 text-center">Incidencia</th>
            <th scope="col" class="px-6 py-2 text-center">Fecha Incidencia</th>
            <th scope="col" class="px-6 py-2 text-center">&Aacute;rea</th>
            <th scope="col" class="px-6 py-2 text-center hidden">C&oacute;digo patrimonial</th>
            <th scope="col" class="px-6 py-2 text-center">Fecha Cierre</th>
            <th scope="col" class="px-6 py-2 text-center">Documento Cierre</th>
            <th scope="col" class="px-6 py-2 text-center">Condici&oacute;n</th>
            <th scope="col" class="px-6 py-2 text-center hidden">Diagn&oacute;stico</th>
            <th scope="col" class="px-6 py-2 text-center hidden">Recomendaciones</th>
            <th scope="col" class="px-6 py-2 text-center">Usuario cierre</th>
            <th scope="col" class="px-6 py-2 text-center">Soluci&oacute;n</th>
            <th scope="col" class="px-6 py-2 text-center">Acci&oacute;n</th>
          </tr>
        </thead>
        <!-- Fin de encabezado -->

        <!-- Cuerpo de la tabla -->
        <tbody>
          <?php if (!empty($cierres)): ?>
            <?php foreach ($cierres as $incidencia) : ?>
              <?php
              $codigoCierre = htmlspecialchars($incidencia['CIE_numero']);
              ?>
              <tr class='second-table hover:bg-green-100 hover:scale-[101%] transition-all border-b' data-id="<?= $codigoCierre; ?>">
                <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap hidden'> <?= $incidencia['CIE_numero']; ?></th>
                <td class='px-6 py-2 text-center'><?= $incidencia['INC_numero_formato']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['fechaIncidenciaFormateada']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['ARE_nombre']; ?></td>
                <td class='px-6 py-2 text-center hidden'><?= $incidencia['INC_codigoPatrimonial']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['fechaCierreFormateada']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['CIE_documento']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['CON_descripcion']; ?></td>
                <td class='px-6 py-2 text-center hidden'><?= $incidencia['CIE_diagnostico']; ?></td>
                <td class='px-6 py-2 text-center hidden'><?= $incidencia['CIE_recomendaciones']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['Usuario']; ?></td>
                <td class='px-6 py-2 text-center'><?= $incidencia['SOL_descripcion']; ?></td>
                <td class="px-6 py-2 justify-center text-center justify-middle flex space-x-2"> <!-- Columna de Acción con botones -->
                  <!-- Botón de Imprimir detalla de incidencia -->
                  <button type="button" id="imprimir-cierre" class="bn btn-warning text-xs text-white font-bold py-2 px-2 rounded-md flex items-center justify-center" title="Imprimir detalle de cierre">
                    <i class="feather icon-printer"></i>
                  </button>

                  <!-- Botón de Eliminar -->
                  <button type="button" class="eliminar-cierre bn btn-danger text-xs text-white font-bold py-2 px-2 rounded-md flex items-center justify-center" title="Eliminar cierre">
                    <i class="feather icon-trash-2"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" class="text-center py-3">No hay incidencias cerradas.</td>
            </tr>
          <?php endif; ?>
        </tbody>
        <!-- Fin del cuerpo de la tabla -->
      </table>
    </div>
    <!-- Fin de la tabla -->
  </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>
<link href="dist/assets/css/plugins/tailwind.min.css" rel="stylesheet">