<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit(); // Terminar el script para evitar que se siga ejecutando
}

require_once 'config/conexion.php';
require_once 'app/Model/IncidenciaModel.php';
require_once 'app/Model/RecepcionModel.php';
require_once 'app/Model/CierreModel.php';
require_once 'app/Controller/InicioController.php';

// Crear una instancia de la conexión a la base de datos
$conexion = new Conexion();
$conector = $conexion->getConexion();
$rol = $_SESSION['rol'];
// Creacion de instancias de los modelos
$incidenciasModel =  new IncidenciaModel();
$recepcionesModel = new RecepcionModel();
$cierresModel = new CierreModel();
$controller = new InicioController();

$cantidadesUsuario = $controller->mostrarCantidadesUsuario();
$incidenciasMes = $cantidadesUsuario['incidencias_mes_actual'];
$recepcionesMes = $cantidadesUsuario['recepciones_mes_actual'];
$cierresMes = $cantidadesUsuario['cierres_mes_actual'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico" />
  <link rel="stylesheet" href="./public/styles/appMenu.css">
  <title>Sistema de incidencias</title>
</head>

<body>
  <!-- Contenedor principal -->
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    include("app/View/partials/user/sideBar.php");
    include("app/View/PnlInicio.php");
    ?>
  </div>
</body>

</html>