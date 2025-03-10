<?php
session_start();
// Verificar si no hay una sesión iniciada
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}
$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CIE_numero = $_GET['CIE_numero'] ?? '';

$rol = $_SESSION['rol'];
$area = $_SESSION['codigoArea'];

require_once 'app/Controller/cierreController.php';
require_once 'app/Controller/mantenimientoController.php';
require_once 'app/Controller/solucionController.php';

$cierreController = new CierreController();
$mantenimientoController = new MantenimientoController();
$solucionController = new SolucionController();

// Paginacion de la tabla de incidencias recepcionadas
$limit = 2; //Numero de filas por pagina
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$start = ($page - 1) * $limit; // Calcula el índice de inicio
$totalRecepcionesSinCerrar = $mantenimientoController->contarIncidenciasFinalizadas();
$totalPages = ceil($totalRecepcionesSinCerrar / $limit);
$recepciones = $mantenimientoController->listarIncidenciasFinalizadas($start, $limit);

$cierres = $cierreController->listarCierres();

switch ($action) {
  case 'registrar':
    $cierreController->registrarCierre();
    break;
  case 'editar':
    $cierreController->actualizarCierre();
    break;
  case 'eliminar':
    $cierreController->eliminarCierre();
    break;
  case 'agregar-solucion':
    $solucionController->registrarSolucion();
    break;
  default:
    break;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <title>Sistema de Gesti&oacute;n de Incidencias</title>
  <link rel="icon" href="public/assets/logo.ico">
  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="" />
  <meta name="keywords" content="">
  <meta name="author" content="GAMM95" />

  <!-- vendor css -->
  <link rel="stylesheet" href="dist/assets/css/style.css">

</head>

<body class="">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <!-- [ navigation menu ] start -->
  <?php
  if ($rol === 'Administrador') {
    include('app/View/partials/admin/navbar.php');
    include('app/View/partials/admin/header.php');
    include('app/View/Registrar/admin/registroCierre.php');
  } else if ($rol === 'Soporte') {
    include('app/View/partials/soporte/navbar.php');
    include('app/View/partials/soporte/header.php');
    include('app/View/Registrar/admin/registroCierre.php');
  }
  ?>
  <!-- [ Main Content ] end -->

  <!-- Required Js -->
  <script src="dist/assets/js/vendor-all.min.js"></script>
  <script src="dist/assets/js/plugins/bootstrap.min.js"></script>
  <script src="dist/assets/js/pcoded.min.js"></script>
  <script src="dist/assets/js/plugins/apexcharts.min.js"></script>
  <!-- Iconos de Feather -->
  <script src="dist/assets/js/plugins/feather.min.js"></script>
  <!-- Select2 -->
  <link href="dist/assets/css/plugins/select2.min.css" rel="stylesheet">
  <script src="dist/assets/js/plugins/select2.min.js"></script>
  <!-- Mensajes toastr -->
  <script src="dist/assets/js/plugins/toastr.min.js"></script>
  <link rel="stylesheet" href="dist/assets/css/plugins/toastr.min.css">
  <!-- Framework CSS -->
  <link href="dist/assets/css/plugins/tailwind.min.css" rel="stylesheet">
  <link href="src/output.css" rel="stylesheet">
  <link rel="stylesheet" href="app/View/partials/scrollbar-styles.css">
  <!-- Generacion de pdf -->
  <script src="dist/assets/js/plugins/jspdf.umd.min.js"></script>
  <script src="dist/assets/js/plugins/jspdf.plugin.autotable.min.js"></script>

  <!-- Archivos cdn -->
  <!-- Mensajes toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Buscador de combos -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Creacion de PDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>

  <!-- Funcionalidades enrutadas -->
  <script src="./public/func/Registros/Cierre/func_cierre_admin.js"></script>
  <script src="./public/func/Registros/Cierre/reporteDetalleCierre.js"></script>
  <script src="./public/func/Registros/Cierre/func_solucion_modal.js"></script>
</body>

</html>