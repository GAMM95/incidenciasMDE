<?php

$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$REC_numero = $_GET['REC_numero'] ?? '';

require_once 'app/Controller/recepcionController.php';
require_once 'app/Model/recepcionModel.php';

$recepcionController = new RecepcionController();
$recepcionModel = new RecepcionModel();

if ($REC_numero != '') {
    global $recepcionRegistrada;
    $recepcionRegistrada = $recepcionModel->obtenerRecepcionPorId($REC_numero);
} else {
    $incidenciaRegistrada = null;
}

switch ($action) {
    case 'registrar':
        $recepcionController->registrarRecepcion();
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
    <div class="flex  w-full mt-20 ">
        <?php
        include("app/View/partials/admin/header.php");
        include("app/View/Registrar/admin/registroRecepcion.php");
        ?>
    </div>
</body>

</html>