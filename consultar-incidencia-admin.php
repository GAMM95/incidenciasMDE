<?php
session_start();
// Verificar si no hay una sesión iniciada
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php"); // Redirigir a la página de inicio de sesión si no hay sesión iniciada
  exit();
}

$action = $_GET['action'] ?? '';
$INC_numero = $_GET['INC_numero'] ?? '';

$area = isset($_GET['area']) ? $_GET['area'] : '';
$codigoPatrimonial = isset($_GET['codigoPatrimonial']) ? $_GET['codigoPatrimonial'] : '';
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

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
    $resultadoBusqueda = NULL;
    if (!empty($area) || !empty($codigoPatrimonial) || !empty($fechaInicio) || !empty($fechaFin)) {
      $resultadoBusqueda = $incidenciaController->consultarIncidenciaAdministrador();
    } else {
      $error = "No se encontraron incidencias para los criterios especificados.";
    }
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

  <title>Sistema de Incidencias - Consultar Incidencias</title>
</head>

<body class="bg-[#eeeff1] flex min-h-screen">
  <!-- Contenido principal -->
  <div class="flex  w-full mt-28">
    <?php
    include("app/View/partials/admin/header.php");
    include("app/View/Consultar/admin/consultaIncidencia.php");
    ?>
  </div>
</body>

</html>