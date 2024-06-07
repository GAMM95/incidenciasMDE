<?php
$action = $_GET['action'] ?? '';
$CodArea = $_GET['ARE_codigo'] ?? '';

require_once 'app/Controller/AreaController.php';
require_once 'app/Model/AreaModel.php';

// Crear una instancia del controlador CategoriaController
$areaController = new AreaController();
$areaModel = new AreaModel();

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title>Sistema de Incidencias - Mantenimiento &Aacute;rea</title>
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