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

<body class="bg-gray-100 flex items-center justify-center min-h-screen overflow-x-hidden">
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <h1 class="text-2xl font-bold mb-4 ">M&oacute;dulo / Categor&iacute;a</h1>

    <form id="formcategoria" action="modulo-categoria.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <!-- PRIMERA FILA: campo para mostrar el numero de Persona -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="flex items-center mb-4">
          <div class="flex items-center">
            <label for="CodCategoria" class="block font-bold mb-1 mr-3 text-lime-500">Código de categoría:</label>
            <input type="text" id="txt_codigoCategoria" name="CodCategoria" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" readonly disabled>
          </div>
        </div>
      </div>

      <!-- SEGUNDA FILA: campo para ingresar el nuevo nombre de la categoria -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="NombreCategoria" class="block mb-1 font-bold text-sm">Nombre categor&iacute;a:</label>
          <input type="text" id="txt_nombreCategoria" name="NombreCategoria" class="border p-2 w-full text-sm">
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          document.getElementById('txt_codigoCategoria').value = '<?php echo isset($CategoriaRegistrada) ? htmlspecialchars($CategoriaRegistrada['CAT_codigo']) : ''; ?>';
          document.getElementById('txt_nombreCategoria').value = '<?php echo isset($CategoriaRegistrada) ? htmlspecialchars($CategoriaRegistrada['CAT_nombre']) : ''; ?>';
        });
      </script>

      <!-- TERCERA FILA: botones -->
      <div class="flex justify-center space-x-4">
        <button type="submit" id="guardar-categoria" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id="editar-categoria" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded" onclick="editarCategoria()">
          Editar
        </button>
        <button type="reset" id="nuevo-registro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded">
          Nuevo
        </button>
      </div>
    </form>

    <!-- TABLA -->
    <div class="relative max-h-[450px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <!-- ENCABEZADO DE LA TABLA -->
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-10 py-3 w-1/6">N°</th>
            <th scope="col" class="px-6 py-3 w-5/6">Categor&iacute;a</th>
          </tr>
        </thead>
        <!-- CUERPO DE LA TABLA -->
        <tbody>
          <?php
          require_once './app/Model/CategoriaModel.php';
          $categoriaModel = new CategoriaModel();
          $categorias = $categoriaModel->listarCategorias();
          foreach ($categorias as $categoria) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b'>";
            echo "<th scope='col' class='px-10 py-4 font-medium text-gray-900 whitespace-nowrap' data-codcategoria='" . htmlspecialchars($categoria['CAT_codigo']) . "'>";
            echo htmlspecialchars($categoria['CAT_codigo']);
            echo "</th>";
            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap' data-categoria='" . htmlspecialchars($categoria['CAT_nombre']) . "'>";
            echo htmlspecialchars($categoria['CAT_nombre']);
            echo "</th>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script src="./app/View/func/func_categoria.js"></script>
</body>
<!-- <script>
  function editarCategoria() {
    const codigo = document.getElementById('txt_codigoCategoria').value;
    const nombre = document.getElementById('txt_nombreCategoria').value;
    if (codigo && nombre) {
      document.getElementById('formcategoria').action = 'modulo-categoria.php?action=editar';
      document.getElementById('formcategoria').submit();
      toastr.success("Categoría actualizada exitosamente");
    } else {
      toastr.error("Error al actualizar la categoría");
    }
  }
</script> -->

</html>