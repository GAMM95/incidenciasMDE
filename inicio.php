<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

require_once 'config/conexion.php';
require_once 'app/Model/IncidenciaModel.php';
require_once 'app/Model/RecepcionModel.php';
require_once 'app/Model/CierreModel.php';
require_once 'app/Controller/InicioController.php';

$conexion = new Conexion();
$conector = $conexion->getConexion();

$rol = $_SESSION['rol'];
$area = $_SESSION['codigoArea']; // Asegúrate de tener el área del usuario en la sesión

// Creacion de instancias de los modelos
$incidenciasModel =  new IncidenciaModel();
$recepcionesModel = new RecepcionModel();
$cierresModel = new CierreModel();
$controller = new InicioController();


if ($rol === 'Administrador' || $rol === 'Soporte') {
  $cantidades = $controller->mostrarCantidadesAdministrador();
} else {
  $cantidades = $controller->mostrarCantidadesUsuario($area);
}

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
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">

    <?php
    // if ($rol === 'Administrador' || $rol === 'Soporte') {
    //   include("app/View/partials/admin/sideBar.php");
    // } else if ($rol === 'Usuario') {
    //   include("app/View/partials/user/sideBar.php");
    // }
    if ($rol === 'Administrador' || $rol === 'Soporte') {
      include("app/View/partials/admin/sideBar.php");
      include("app/View/Inicio/admin/PnlInicio.php");
    } else {
      include("app/View/partials/user/sideBar.php");
      include("app/View/Inicio/user/PnlInicio.php");
    }
    ?>
  </div>
</body>

</html>