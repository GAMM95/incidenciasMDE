<?php
$action = $_GET['action'] ?? '';
$INC_numero = $_GET['INC_numero'] ?? '';

require_once 'app/Controller/incidenciaController.php';
$incidenciaController = new IncidenciaController();
$incidenciaModel = new IncidenciaModel();

if ($INC_numero != '') {
  global $incidenciaRegistrada;
  $incidenciaRegistrada = $incidenciaModel->obtenerIncidenciaPorId($INC_numero);
} else {
  $incidenciaRegistrada = null;
}

switch ($action) {
  case 'registrar':
    $incidenciaController->registrarIncidencia();
    break;
  case 'consultar':
    $area = $_GET['area'] ?? null;
    $codigoPatrimonial = $_GET['codigoPatrimonial'] ?? null;
    $fechaInicio = $_GET['fechaInicio'] ?? null;
    $fechaFin = $_GET['fechaFin'] ?? null;

    if ($area !== null || $codigoPatrimonial !== null || $fechaInicio !== null || $fechaFin !== null) {
      $incidencias = $incidenciaController->consultarIncidenciaAdministrador($area, $codigoPatrimonial, $fechaInicio, $fechaFin);

      if (empty($incidencias)) {
        $error = "No se encontraron incidencias para los criterios especificados.";
      }

      include("app/View/Consultar/admin/consultaIncidencia.php");
    } else {
      $error = "Debe especificar al menos uno de los criterios de búsqueda.";
      include("app/View/Consultar/admin/consultaIncidencia.php");
    }
    break;

  default:
    // Cualquier otra lógica que necesites manejar
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

  <title>Sistema de Incidencias - Consultar Incidencias</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="flex s?? null;hadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/View/partials/admin/sideBar.php");
    include("app/View/Consultar/admin/consultaIncidencia.php");
    ?>
  </div>
</body>

</html>