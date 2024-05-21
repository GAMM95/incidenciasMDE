<?php
$action = $_GET['action'] ?? '';
$state = $_GET['state'] ?? '';
$CodPersona = $_GET['PER_codigo'] ?? '';

require_once 'app/Controller/PersonaController.php';

// Obtener los datos necesarios
$dni = $_POST['dni'] ?? '';
$nombres = $_POST['nombre'] ?? '';
$apellidoPaterno = $_POST['apellidoPaterno'] ?? '';
$apellidoMaterno = $_POST['apellidoMaterno'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';

// Crear una instancia del controlador PersonaController
$personaController = new PersonaController($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);
$personaModel = new PersonaModel();

if ($CodPersona != '') {
  global $PersonaRegistrada;
  $PersonaRegistrada = $personaModel->obtenerPersonaPorId($CodPersona);
} else {
  $PersonaRegistrada = null;
}


switch ($action) {
  case 'registrar':
    $personaController->registrarPersona();
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

  <title>Sistema de Incidencias - Mantenimiento Persona</title>
</head>


<body class="bg-gray-100 flex items-center justify-center min-h-screen">


  <div class="flex shadow-lg p-8 rounded-lg w-full sm:h-screen">
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/View/partials/admin/sideBar.php");
    ?>
    <?php
    // Incluir la barra lateral desde un archivo externo
    include("app/views/Mantenimiento/mantenedorPersona.php");
    ?>
  </div>
</body>

</html>