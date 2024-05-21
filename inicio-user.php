<?php
// Iniciar la sesión para mantener el estado del usuario
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['username'])) {
  // Redirigir al usuario a la página de inicio de sesión si no hay una sesión iniciada
  header("Location: index.php");
  exit(); // Terminar el script para evitar que se siga ejecutando
}

require_once 'config/conexion.php';

// Crear una instancia de la conexión a la base de datos
$conexion = new Conexion();
$conector = $conexion->getConexion();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico" />

  <!-- Importación de estilos -->
  <link rel="stylesheet" href="./public/styles/appMenu.css">
  <title>Consulta Transportes</title>
</head>

<body>
  <!-- Contenedor principal -->
  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/View/partials/user/sideBar.php");
    ?>
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/View/PnlInicio.php");
    ?>
  </div>
</body>

</html>