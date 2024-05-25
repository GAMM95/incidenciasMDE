<?php
$action = $_GET['action'] ?? '';
$CodCategoria = $_GET['CAT_codigo'] ?? '';

require_once 'app/Controller/CategoriaController.php';
require_once 'app/Model/CategoriaModel.php';

// Crear una instancia del controlador CategoriaController
$categoriaController = new CategoriaController();
$categoriaModel = new CategoriaModel();

if ($CodCategoria != '') {
  $CategoriaRegistrada = $categoriaModel->obtenerCategoriaPorId($CodCategoria);
} else {
  $CategoriaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $categoriaController->registrarCategoria();
    break;
  default:
    // Código por defecto o mostrar alguna vista por defecto
    break;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico" />
  <script src="https://cdn.tailwindcss.com"></script>

  <title>Sistema de Incidencias - Mantenimiento Rol</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/View/partials/admin/sideBar.php");
    ?>
    <?php
    // Incluir la vista del mantenedor de categorías
    include("app/View/Mantenimiento/mantenedorCategoria.php");
    ?>
  </div>
</body>

</html>