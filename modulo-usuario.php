<?php
$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CodUsuario = $_GET['USU_codigo'] ?? '';

require_once 'app/Controller/UsuarioController.php';

// Crear una instancia del controlador PersonaController
$usuarioController = new UsuarioController();
$usuarioModel = new UsuarioModel();

if ($CodUsuario != '') {
  global $UsuarioRegistrado;
  $UsuarioRegistrado = $usuarioModel->obtenerRolPorId($CodPersona);
} else {
  $UsuarioRegistrado = null;
}

switch ($action) {
  case 'registrar':
    $usuarioController->registrarUsuario();
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

  <title>Sistema de Incidencias - Mantenimiento Persona</title>
</head>

<body class="bg-[#eeeff1] flex min-h-screen">
  <!-- Contenido principal -->
  <div class="flex  w-full mt-28">
    <?php
    include("app/View/partials/admin/header.php");
    include("app/View/Mantenimiento/mantenedorUsuario.php");
    ?>
  </div>
</body>

</html>