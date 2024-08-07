<?php
$action = $_GET['action'] ?? '';
$CodPersona = $_GET['PER_codigo'] ?? '';

require_once 'app/Controller/PersonaController.php';
require_once 'app/Model/PersonaModel.php';

// Crear una instancia del controlador PersonaController
$personaController = new PersonaController();
$personaModel = new PersonaModel();

if ($CodPersona != '') {
  global $PersonaRegistrada;
  $PersonaRegistrada = $personaModel->obtenerPersonaPorId($CodPersona);
} else {
  $PersonaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $personaController->registrarPersona();
    break;
  case 'editar':
    $personaController->actualizarPersona();
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title>Sistema de Incidencias - Mantenimiento Categoría</title>
</head>

<body class="bg-[#eeeff1] flex min-h-screen">
  <!-- Contenido principal -->
  <div class="flex  w-full mt-28">
    <?php
    include("app/View/partials/admin/header.php");
    include("app/View/Mantenimiento/mantenedorPersona.php");
    ?>
  </div>
</body>

</html>