<?php

$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CIE_numero = $_GET['CIE_numero'] ?? '';

require_once 'app/Controller/cierreController.php';
require_once 'app/Model/cierreModel.php';

$cierreController = new CierreController();
$cierreModel = new CierreModel();

if ($CIE_numero != '') {
  global $cierreRegistrado;
  $cierreRegistrado = $cierreModel->obtenerCierrePorID($CIE_numero);
} else {
  $cierreRegistrado = null;
}

switch ($action) {
  case 'registrar':
    $cierreController->registrarCierre();
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

  <title>Sistema de Incidencias - Registro de Incidencias</title>
</head>

<body class="bg-[#eeeff1] flex min-h-screen">
  <!-- Contenido principal -->
  <div class="flex  w-full mt-28">
    <?php
    include("app/View/partials/admin/header.php");
    include("app/View/Registrar/admin/registroCierre.php");
    ?>
  </div>
</body>

</html>