<?php
$action = $_GET['action'] ?? '';
$CodRol = $_GET['ROL_codigo'] ?? '';

require_once 'app/Controller/RolController.php';
require_once 'app/Model/RolModel.php';

// Obtener los datos necesarios
$nombre = $_POST['nombre'] ?? '';


// Crear una instancia del controlador RolController
$rolController = new RolController($nombre);
$rolModel = new RolModel($nombre);

if ($CodRol != '') {
  global $RolRegistrado;
  $RolRegistrado = $rolModel->obtenerRolPorId($CodRol);
} else {
  $RolRegistrado = null;
}

switch ($action) {
  case 'registrar':
    $rolController->registrarRol();
    break;
  case 'editar':
    $rolController->editarRol();
    break;
  default:
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
    include("app/View/partials/admin/sideBar.php");
    include("app/View/Mantenimiento/mantenedorRol.php");
    ?>
  </div>
</body>

</html>