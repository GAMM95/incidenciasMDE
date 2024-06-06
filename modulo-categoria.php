<?php
$action = $_GET['action'] ?? '';
$CodCategoria = $_GET['CAT_codigo'] ?? '';

require_once 'app/Controller/CategoriaController.php';
require_once 'app/Model/CategoriaModel.php';

// Crear una instancia del controlador y modelo de categoría
$categoriaController = new CategoriaController();
$categoriaModel = new CategoriaModel();

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title>Sistema de Incidencias - Mantenimiento Categoría</title>
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen overflow-x-hidden">
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    include("app/View/partials/admin/sideBar.php");
    include("app/View/Mantenimiento/mantenedorCategoria.php");
    ?>
  </div>
</body>

</html>
