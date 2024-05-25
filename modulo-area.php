<?php
$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CodCategoria = $_GET['ARE_codigo'] ?? ''; // Definir $CodCategoria

require_once 'app/Controller/AreaController.php';
require_once 'app/Model/AreaModel.php';

// Obtener los datos necesarios
$nombre = $_POST['nombre'] ?? '';

// Crear una instancia del controlador CategoriaController
$areaController = new AreaController($nombre);
$areaModel = new AreaModel($nombre);

if ($CodCategoria != '') {
  $CategoriaRegistrada = $categoriaModel->obtenerCategoriaPorId($CodCategoria);
} else {
  $CategoriaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $categoriaController->registrarCategoria();
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
    // Incluir la barra lateral desde un archivo externo
    include("app/View/Mantenimiento/mantenedorArea.php");
    ?>
  </div>
</body>

</html>