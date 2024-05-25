<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">

  <!-- Importación de librería jQuery -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Agrega las hojas de estilo de Tailwind CSS -->
  <link href="http//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Agrega la fuente Poppins desde Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <!-- Implementación de funcionalidades para la vista cliente -->
  <script src="app/Views/Func/password-toggle.js"></script>
  <!-- Implementación de iconos-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Incluye Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body>
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <?php
    global $consultaIncidencia;
    ?>
    <!-- Formulario -->
    <div class="mb-8 mt-8">

      <form id="formIncidencia" method="POST">

        <div class="flex flex-wrap -mx-2">
          <div class="w-full md:w-1/3 px-2 mb-2">
            <h1 class="text-xl font-bold mb-4">Consultar Incidencia</h1>
          </div>
          <div class="w-full md:w-1/6 px-2 mb-2">
            <label for="FechaIncidencia" class="block mb-2 font-bold text-sm">AÑO:</label>
          </div>
          <div class="w-full md:w-1/6 px-200 mb-2">
            <select id="FechaIncidencia" type="search" name="FechaIncidencia" class="border p-2 w-full text-sm">
            </select>
          </div>
          <div class="w-full md:w-1/6 px-20 mb-2">
            <button type="submit" id="enviar" class="bg-blue-500 text-white font-bold hover:bg-[#4c8cf5] py-2 px-4 rounded">
              Todos
            </button>
          </div>

        </div>

        <div class="flex flex-wrap -mx-2">
          <div class="w-full sm:w-1/2 md:w-1/6 px-2 mb-2">
            <label for="numero_incidencia" class="block mb-1 font-bold text-sm">Nro de Incidencia:</label>
            <input type="text" id="numero_incidencia" name="numero_incidencia" class="w-full border-gray-300 rounded-md p-2 text-sm">
          </div>
          <div class="w-full md:w-1/3 px-2 mb-2">
            <label for="area" class="block mb-1 font-bold text-sm">Área:</label>
            <select id="area" name="area" class="border p-2 w-full text-sm">
            </select>
          </div>
          <div class="w-full sm:w-1/3 md:w-1/5 px-2 mb-2">
            <label for="fecha" class="block mb-1 font-bold text-sm">Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="w-full border-gray-300 rounded-md p-2 text-sm">
          </div>
          <!-- Botones del formulario -->
          <div class="flex justify-center space-x-2 mt-6">

            <button type="button" id="buscarIncidencia" class="bg-blue-500 text-white font-bold hover:bg-[#4c8cf5] py-2 px-4 rounded">
              Buscar
            </button>
            <button type="reset" class="bg-green-400 text-white font-bold hover:bg-gray-400 py-2 px-4 rounded">
              Limpiar
            </button>
          </div>
        </div>


      </form>
    </div>

    <!-- RESULTADOS -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

      <table id="tablaConsultarIncidencias" class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-3 py-3"> N° Inc </th>
            <th scope="col" class="px-3 py-3"> C&oacute;digo Patrimonial </th>
            <th scope="col" class="px-3 py-3"> Categor&iacute;a </th>
            <th scope="col" class="px-3 py-3"> Fecha Recepci&oacute;n </th>
            <th scope="col" class="px-3 py-3"> Asunto </th>
            <th scope="col" class="px-3 py-3"> &Aacute;rea </th>
            <th scope="col" class="px-3 py-3"> Descripci&oacute;n </th>
            <th scope="col" class="px-3 py-3"> Documento </th>
            <th scope="col" class="px-3 py-3"> Hora </th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once './app/models/consultarIncMo.php'; // Asegúrate de tener el modelo correcto para la recepción
          $incidenciaModel = new IncidenciaModel();
          try {
            $incidencias = $incidenciaModel->listarIncidencias(); // Método para obtener datos de recepción desde la base de datos

            foreach ($incidencias as $incidencia) {
              echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
              echo "<td class='px-6 py-4'>" . $incidencia['NumIncidencia'] . "</td>";
              echo "<td id='incCodigo' class=' hidden px-6 py-4'>" . $incidencia['NumIncidencia'] . "</td>";
              echo "<td class='px-6 py-4'>" . $incidencia['CodPatrimonial'] . "</td>";
              echo "<td class='px-6 py-4'>" . $incidencia['DescripcionCategoria'] . "</td>";
              echo "<td class='px-6 py-4'>" . $incidencia['FechaIncidencia'] . "</td>";
              echo "<td class='px-6 py-4'>" . $incidencia['Asunto'] . "</td>";
              echo "<td class='px-6 py-4'>" . $incidencia['NombreArea'] . "</td>";
              echo "<td class='px-16 py-4'>" . $incidencia['Descripcion'];
              echo "<td class='px-6 py-4'>" . $incidencia['NumDocumento'];
              echo "<td class='px-6 py-4'>" . $incidencia['Hora'];
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
  </main>

</body>