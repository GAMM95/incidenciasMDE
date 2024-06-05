<?php
$action = $_GET['action'] ?? '';
$CodArea = $_GET['ARE_codigo'] ?? '';

require_once 'app/Controller/AreaController.php';
require_once 'app/Model/AreaModel.php';

// Obtener los datos necesarios
$nombre = $_POST['nombre'] ?? '';

// Crear una instancia del controlador CategoriaController
$areaController = new AreaController($nombre);
$areaModel = new AreaModel($nombre);

if ($CodArea != '') {
  $AreaRegistrada = $areaModel->obtenerAreaPorId($CodArea);
} else {
  $AreaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $areaController->registrarArea();
    break;
  case 'editar':
    $areaController->editarArea();
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

  <title>Sistema de Incidencias - Mantenimiento Area</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    include("app/View/partials/admin/sideBar.php");
    include("app/View/Mantenimiento/mantenedorArea.php");
    ?>
  </div>
</body>

</html>