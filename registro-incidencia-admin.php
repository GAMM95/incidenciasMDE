<?php

$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$INC_codigo = $_GET['INC_codigo'] ?? '';

require_once 'app/Controller/incidenciaController.php';
require_once 'app/Model/incidenciaModel.php';

$incidenciaController = new IncidenciaController();
$incidenciaModel = new IncidenciaModel();


if ($INC_codigo != '') {
    global $incidenciaRegistrada;
    $incidenciaRegistrada = $incidenciaModel->obtenerIncidenciaPorId($INC_codigo);
} else {
    $incidenciaRegistrada = null;
}

switch ($action) {
    case 'registrar':
        $incidenciaController->registrarIncidencia();
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


<body class="bg-green-50 flex items-center justify-center min-h-screen">


    <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
        <?php
        // Incluir la barra lateral desde un archivo externo
        include("app/View/partials/admin/sideBar.php");
        ?>
        <?php
        // Incluir la barra lateral desde un archivo externo
        include("app/View/Registrar/admin/registroIncidencias.php");
        ?>
    </div>
</body>

</html>