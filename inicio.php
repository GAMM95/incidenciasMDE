<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

require_once 'config/conexion.php';
$conexion = new Conexion();
$conector = $conexion->getConexion();

$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico" />
  <link rel="stylesheet" href="./public/styles/appMenu.css">
  <title>Consulta Transportes</title>
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
    } else {
      include("app/View/partials/user/sideBar.php");
    }
    ?>

    <?php include("app/View/PnlInicio.php"); ?>
  </div>
</body>

</html>