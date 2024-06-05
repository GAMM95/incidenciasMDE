<?php
$action = $_GET['action'] ?? '';
$CodCategoria = $_GET['CAT_codigo'] ?? '';

require_once 'app/Controller/categoriaController.php';
require_once 'app/Model/CategoriaModel.php';

// Obtener los datos necesarios
$nombre = $_POST['nombre'] ?? '';

// Crear una instancia del controlador RolController
$categoriaController = new CategoriaController($nombre);
$categoriaModel = new CategoriaModel($nombre);

if ($CodCategoria != '') {
  global $CategoriaRegistrada;
  $CategoriaRegistrada = $categoriaModel->obtenerCategoriaPorId($CodCategoria);
} else {
  $CategoriaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $categoriaController->registrarCategoria();
    break;
  case 'editar':
    $categoriaController->editarCategoria();
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

  <title>Sistema de Incidencias - Mantenimiento CAtegoria</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    include("app/View/partials/admin/sideBar.php");
    include("app/View/Mantenimiento/mantenedorCategoria.php");
    ?>
  </div>
</body>

</html>