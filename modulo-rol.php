<?php
$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CodRol = $_GET['ROL_codigo'] ?? '';

require_once 'app/Controller/RolController.php';

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
    include("app/View/Mantenimiento/mantenedorRol.php");
    ?>
  </div>
</body>

</html>