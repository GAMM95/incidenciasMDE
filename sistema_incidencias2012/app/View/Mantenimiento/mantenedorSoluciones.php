<div class="pcoded-main-container mt-5">
  <div class="pcoded-content">
    <!-- Miga de pan -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h1 class="text-2xl font-bold mb-2">Registro de soluciones</h1>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href=""><i class="feather icon-server"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Mantenedor</a></li>
              <li class="breadcrumb-item"><a href="">Soluciones</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin de miga de pan -->

    <!-- Conteneder principal para el formulario y la tabla -->
    <div class="flex space-x-4">
      <!-- Formulario de registro de solucion -->
      <div class="flex flex-col w-1/3">
        <form id="formSolucion" action="modulo-solucion.php?action=registrar" method="POST" class="card table-card bg-white shadow-md p-6 w-full text-xs">
          <input type="hidden" id="form-action" name="action" value="registrar">
          <!-- Codigo de solucion -->
          <div class="flex justify-center -mx-2 mb-5 hidden">
            <div class="flex items-center mb-4">
              <div class="flex items-center">
                <label for="codigoSolucion" class="block font-bold mb-1 mr-3 text-lime-500">C&oacute;digo de soluci&oacute;n:</label>
                <input type="text" id="codigoSolucion" name="codigoSolucion" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
              </div>
            </div>
          </div>

          <!-- Nombre de solucion -->
          <div class="flex flex-wrap -mx-2">
            <div class="w-full px-2 mb-3">
              <label for="descripcionSolucion" class="block mb-1 font-bold text-xs">Descripci&oacute;n de soluci&oacute;n:</label>
              <input type="text" id="descripcionSolucion" name="descripcionSolucion" class="border p-2 w-full text-xs rounded-md" pattern="[A-Za-z\s]+" placeholder="Ingrese nueva descripci&oacute;n de soluci&oacute;n"  oninput="capitalizeInput(this)">
            </div>
          </div>

          <!-- Botones del fomulario -->
          <div class="flex justify-center space-x-4">
            <button type="submit" id="guardar-solucion" class="bn btn-primary text-xs text-white font-bold py-2 px-3 rounded-md disabled:bg-gray-300 disabled:cursor-not-allowed"><i class="feather mr-2 icon-save"></i>Registrar</button>
            <button type="button" id="editar-solucion" class="bn btn-info text-xs text-white font-bold py-2 px-3 rounded-md disabled:bg-gray-300 disabled:cursor-not-allowed" disabled><i class="feather mr-2 icon-edit"></i>Actualizar</button>
            <button type="button" id="nuevo-registro" class="bn btn-secondary text-xs text-white font-bold py-2 px-3 rounded-md"> <i class="feather mr-2 icon-plus-square"></i>Limpiar</button>
          </div>
          <!-- Fin de botones del formulario -->
        </form>
      </div>
      <!-- Fin de formulario de registro -->

      <!-- Tabla de soluciones -->
      <div class="w-2/3">
        <div class="relative max-h-[800px] overflow-x-hidden shadow-md sm:rounded-lg">
          <table id="tablaSoluciones" class="w-full text-xs text-left rtl:text-right text-gray-500 cursor-pointer bg-white">
            <!-- Encabezado de la tabla -->
            <thead class="sticky top-0 text-xs text-gray-70 uppercase bg-lime-300">
              <tr>
                <th scope="col" class="px-10 py-2 w-1/8 text-center">N&deg;</th>
                <th scope="col" class="px-6 py-2 w-5/6 text-center">Soluci&oacute;n</th>
                <th scope="col" class="px-6 py-2 w-2/6 text-center">Acci&oacute;n</th>
              </tr>
            </thead>
            <!-- Fin de encabezado -->

            <!-- Encabezado de la tabla -->
            <tbody>
              <?php $item = 1; // Iniciar contador para el ítem 
              ?>
              <?php if (!empty($resultado)): ?>
                <?php foreach ($resultado as $solucion) : ?>
                  <?php
                  $estado = htmlspecialchars($solucion['EST_codigo']);
                  $isActive = ($estado === '1');
                  $codigoSolucion = htmlspecialchars($solucion['SOL_codigo']);
                  // Aplicar clase de texto rojo si el ARE_estado es 2
                  $solucionInactiva = ($estado == 2) ? 'text-red-600' : 'text-gray-900';
                  ?>
                  <tr class='second-table hover:bg-green-100 hover:scale-[101%] transition-all border-b' data-id="<?= $codigoSolucion; ?>">
                    <th scope='row' class='px-6 py-2 font-medium text-gray-900 whitespace-nowrap hidden'><?= $codigoSolucion; ?></th>
                    <td class="px-2 py-2 text-center"><?= $item++ ?></td> <!-- Columna de ítem -->
                    <td class='px-6 py-2 w-2/3 <?= $solucionInactiva; ?>'><?= $solucion['SOL_descripcion']; ?></td>
                    <td class="px-6 py-2 text-center">
                      <div class="custom-control custom-switch cursor-pointer">
                        <input type="checkbox" class="custom-control-input switch-solucion" id="customswitch<?= $codigoSolucion; ?>" data-id="<?= $codigoSolucion; ?>" <?= $isActive ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="customswitch<?= $codigoSolucion; ?>"><?= $isActive ? 'Activo' : 'Inactivo'; ?></label>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center py-3">No se han registrado nuevas soluciones.
                </tr>
              <?php endif; ?>
            </tbody>
            <!-- Fin del cuerpo de la tabla -->
          </table>
        </div>
      </div>
      <!-- Fin de la tabla de soluciones -->
    </div>
  </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>