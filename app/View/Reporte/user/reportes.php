<div class="pcoded-main-container h-screen flex flex-col mt-5">
  <div class="pcoded-content flex flex-col grow">
    <!-- Inicio de breadcrumb -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h1 class="text-2xl font-bold mb-2">Reportes de incidencias</h1>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href=""><i class="feather icon-file"></i></a></li>
              <li class="breadcrumb-item"><a href="reportes.php">Reportes</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin de breadcrumb -->

    <!-- Inicio del tab pane -->
    <div class="h-full flex flex-col grow mb-0">
      <div class="card grow">
        <div class="card-body flex flex-col grow pt-2">
          <!-- Contenido de la segunda pestaña  - REPORTES DE DETALLE -->
          <div class="tab-pane fade show active" id="detalle" role="tabpanel" aria-labelledby="detalle-tab">
            <div class="flex items-center mb-4 hidden">
              <!-- Número de incidencia -->
              <label for="num_incidencia" class="block mb-1 mr-1">N&deg; Incidencia:</label>
              <input type="text" id="num_incidencia" name="num_incidencia" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
              <!-- Fin de número de incidencia -->
              <!-- Numero de cierre -->
              <label for="num_cierre" class="block mb-1 mr-1">N&deg; Cierre:</label>
              <input type="text" id="num_cierre" name="num_cierre" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-xs text-center" readonly>
              <!-- Fin de numero de cierre -->
            </div>

            <!-- Buscador de termino -->
            <div class="flex justify-between items-center mt-2">
              <input type="text" id="termino" class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 text-xs" placeholder="Buscar incidencia..." oninput="filtrarTablaIncidenciasDetalleArea()" />
            </div>
            <!-- Fin de buscador de termino -->

            <!-- Tabla de incidencias -->
            <div class="relative sm:rounded-lg mt-3">
              <div class="max-w-full overflow-hidden sm:rounded-lg">
                <table id="tablaIncidenciasDetalleArea" class="bg-white w-full text-xs text-left rtl:text-right text-gray-500 cursor-pointer">
                  <!-- Encabezado de la tabla -->
                  <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-blue-300">
                    <tr>
                      <th scope="col" class="px-3 py-2 text-center hidden">INC_numero</th>
                      <th scope="col" class="px-3 py-2 text-center hidden">Num_cierre</th>
                      <th scope="col" class="px-3 py-2 text-center">N&deg;</th>
                      <th scope="col" class="px-3 py-2 text-center">Incidencia</th>
                      <th scope="col" class="px-3 py-2 text-center">Fecha Inc.</th>
                      <th scope="col" class="px-3 py-2 text-center">Asunto</th>
                      <th scope="col" class="px-3 py-2 text-center">Documento</th>
                      <th scope="col" class="px-3 py-2 text-center">C&oacute;d. Patrimonial</th>
                      <th scope="col" class="px-3 py-2 text-center">Nombre del Bien</th>
                      <th scope="col" class="px-3 py-2 text-center">Prioridad</th>
                      <th scope="col" class="px-3 py-2 text-center">Estado</th>
                      <th scope="col" class="px-3 py-2 text-center">Reporte</th>
                    </tr>
                  </thead>
                  <!-- Fin de encabezado de la tabla -->

                  <!-- Cuerpo de la tabla -->
                  <tbody>
                    <?php $item = 1; // Iniciar contador para el ítem 
                    ?>
                    <?php foreach ($resultadoIncidenciasDetalleArea as $detalles): ?>
                      <tr class="second-table hover:bg-green-100 hover:scale-[101%] transition-all border-b" data-id="<?= $detalles['INC_numero']; ?>">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap hidden"><?= $detalles['INC_numero']; ?></th>
                        <td class="px-3 py-2 text-center hidden"><?= htmlspecialchars($detalles['INC_numero']) ?></td>
                        <td class="px-3 py-2 text-center hidden"><?= htmlspecialchars($detalles['CIE_numero']) ?></td>
                        <td class="px-3 py-2 text-center"><?= $item++ ?></td> <!-- Columna de ítem -->

                        <td class="px-3 py-2 text-center"><?= $detalles['INC_numero_formato']; ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['fechaIncidenciaFormateada']); ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['INC_asunto']); ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['INC_documento']); ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['INC_codigoPatrimonial']); ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['BIE_nombre']); ?></td>
                        <td class="px-3 py-2 text-center"><?= htmlspecialchars($detalles['PRI_nombre']); ?></td>
                        <td class="px-3 py-2 text-center  text-xs align-middle">
                          <?php
                          $estadoDescripcion = htmlspecialchars($detalles['Estado']);
                          $badgeClass = '';
                          switch ($estadoDescripcion) {
                            case 'ABIERTO':
                              $badgeClass = 'badge-light-danger';
                              break;
                            case 'RECEPCIONADO':
                              $badgeClass = 'badge-light-success';
                              break;
                            case 'CERRADO':
                              $badgeClass = 'badge-light-primary';
                              break;
                            default:
                              $badgeClass = 'badge-light-secondary';
                              break;
                          }
                          ?>
                          <label class="badge <?= $badgeClass ?>"><?= $estadoDescripcion ?></label>
                        </td>
                        <td class="px-6 py-3 justify-center text-center align-middle flex space-x-2"> 
                          <!-- Botón de Imprimir detalle de incidencia -->
                          <button type="button" id="imprimir-incidencia" class="bn btn-warning text-xs text-white font-bold py-2 px-3 rounded-md flex items-center justify-center" title="Detalle de incidencia">
                            <i class="feather icon-file"></i>
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php if (empty($resultadoIncidenciasDetalleArea)): ?>
                      <tr>
                        <td colspan="12" class="text-center py-3">No se encontraron registros de incidencias.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                  <!-- Fin de cuerpo de tabla -->
                </table>
              </div>
            </div>
            <!-- Fin de tabla de incidencias -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Final del tab pane -->
</div>

<script src="https://cdn.tailwindcss.com"></script>