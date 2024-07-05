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
    include("app/View/Consultar/admin/consultaRecepcion.php");
    ?>
  </div>
</body>

</html>