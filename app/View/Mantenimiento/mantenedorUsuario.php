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

<body class="bg-green-50 flex items-center justify-center min-h-screen overflow-x-hidden">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-4">M&oacute;dulo / Usuario</h1>

    <form id="formUsuario" action="modulo-usuario.php" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <input type="hidden" id="form-action" name="action" value="registrar">

      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <div class="flex items-center">
            <label for="CodUsuario" class="block font-bold mb-1 mr-3 text-lime-500">C&oacute;digo de Usuario:</label>
            <input type="text" id="txt_codigoUsuario" name="CodUsuario" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" readonly disabled>
          </div>
        </div>
      </div>

      <!-- SEGUNDA fila: Persona, Área y Rol -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="persona" class="block mb-1 font-bold text-sm">Persona:</label>
          <select id="cbo_persona" name="CodPersona" class="border p-2 w-full text-sm cursor-pointer" title="Seleccione una persona">
            <option value="" selected disabled class="text-gray-200">Seleccione una persona</option>
          </select>
        </div>
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="CodArea" class="block mb-1 font-bold text-sm">&Aacute;rea:</label>
          <select id="cbo_area" name="CodArea" class="border p-2 w-full text-sm cursor-pointer" title="Seleccione un &aacute;rea">
            <option value="" selected disabled class="text-gray-200">Seleccione una &aacute;rea</option>
          </select>
        </div>
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="CodRol" class="block mb-1 font-bold text-sm">Rol:</label>
          <select id="cbo_rol" name="CodRol" class="border p-2 w-full text-sm cursor-pointer" title="Seleccione un rol">
            <option value="" selected disabled class="text-gray-200">Seleccione un rol</option>
          </select>
        </div>
      </div>


      <!-- CUARTA fila: Usuario, Contraseña -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="nombre" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="txt_nombreUsuario" name="nombre" class="border p-2 w-full text-sm" placeholder="Ingrese nombre de usuario">
        </div>

        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="password" class="block mb-1 font-bold text-sm">Contrase&ntilde;a:</label>
          <input type="text" id="txt_password" name="password" class="border p-2 w-full text-sm" placeholder="Ingrese contraseña">
        </div>
      </div>

      <!-- Botones -->
      <div class="flex justify-center space-x-4 mt-2 mb-2">
        <button type="submit" id="guardar-usuario" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id="editar-usuario" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
          Editar
        </button>
        <button type="reset" id="nuevo-registro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded">
          Nuevo
        </button>
      </div>

    </form>

    <!-- Tabla de personas -->
    <div class="relative max-h-[450px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-6 py-1"> N° </th>
            <th scope="col" class="px-6 py-1"> Nombre completo </th>
            <th scope="col" class="px-6 py-3"> &Aacute;rea </th>
            <th scope="col" class="px-6 py-3"> Usuario </th>
            <th scope="col" class="px-6 py-3"> Contrase&ntilde;a </th>
            <th scope="col" class="px-6 py-3"> Rol</th>
            <th scope="col" class="px-6 py-3"> Estado </th>
            <th scope="col" class="px-6 py-3"> Opciones </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $usuarios = $usuarioModel->listarUsuario();
          foreach ($usuarios as $usuario) {
            $estado = htmlspecialchars($usuario['EST_descripcion']);
            $isActive = ($estado === 'Activo');

            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
            echo "<th scope='col' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap' data-codusuario='" . htmlspecialchars($usuario['USU_codigo']) . "'>";
            echo htmlspecialchars($usuario['USU_codigo']);
            echo "</th>";

            echo "<td class='px-6 py-4' data-nombre='" . htmlspecialchars($usuario['persona']) . "' data-codpersona='" . (isset($usuario['PER_codigo']) ? htmlspecialchars($usuario['PER_codigo']) : "") . "'>";
            echo htmlspecialchars($usuario['persona']);
            echo "</td>";

            echo "<td class='px-6 py-4' data-area='" . (isset($usuario['ARE_codigo']) ? htmlspecialchars($usuario['ARE_codigo']) : "") . "' data-codarea='" . (isset($usuario['ARE_codigo']) ? htmlspecialchars($usuario['ARE_nombre']) : "") . "'>";
            echo htmlspecialchars($usuario['ARE_nombre']);
            echo "</td>";

            echo "<td class='px-6 py-4' data-usuario='" . htmlspecialchars($usuario['USU_nombre']) . "'>";
            echo htmlspecialchars($usuario['USU_nombre']);
            echo "</td>";

            echo "<td class='px-6 py-4' data-password='" . htmlspecialchars($usuario['USU_password']) . "'>";
            echo htmlspecialchars($usuario['USU_password']);
            echo "</td>";

            echo "<td class='px-6 py-4' data-password='" . htmlspecialchars($usuario['ROL_nombre']) . "'>";
            echo htmlspecialchars($usuario['ROL_nombre']);
            echo "</td>";

            echo "<td class='px-6 py-4' data-estado='" . $estado . "' data-codrol='" . (isset($usuario['ROL_codigo']) ? htmlspecialchars($usuario['ROL_codigo']) : "") . "'>";
            echo $estado;
            echo "</td>";

            echo "<td class='px-6 py-4'>
            <div class='flex'>
              <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2 " . ($isActive ? "bg-gray-500 cursor-not-allowed" : "") . "' " . ($isActive ? "disabled" : "") . ">Activar</button>
              <button class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded " . (!$isActive ? "bg-gray-500 cursor-not-allowed" : "") . "' " . (!$isActive ? "disabled" : "") . ">Deshabilitar</button>
            </div>
          </td>";
            echo "</tr>";
          }
          ?>



        </tbody>
      </table>
    </div>
  </main>
  <!-- <script src="./app/View/func/func_usuario.js"></script> -->
  <script src="./app/View/func/func_usuario.js"></script>
</body>
<!-- <script src="./app/View/func/func_usuario.js"></script> -->

</html>