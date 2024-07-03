<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto relative rounded-lg shadow-md">
    <img src="public/assets/fondo2.jpg" alt="Logo" class="w-full h-full object-cover absolute inset-0 opacity-75 z-0">

    <div class="relative z-10 flex flex-col items-center justify-center min-h-full">
      <!-- Título principal -->
      <!-- <h1 class="text-4xl font-bold text-green-500 mb-8">Sistema de Incidencias</h1> -->
      <div class="bg-white p-6 rounded-lg shadow-lg text-center mb-8">
        <h1 class="text-4xl font-bold text-green-500">Sistema de Incidencias</h1>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card de Asociaciones -->
        <div class="card bg-white p-6 rounded-lg shadow-lg text-center">
          <!-- <div class="logoCard mb-4">
            <img src="./public/assets/asociaciones.png" class="mx-auto" alt="Imagen de la tarjeta">
          </div> -->
          <!-- Cantidad Asociaciones -->
          <h2 class="tituloReporte text-xl font-semibold mb-2">Total de incidencias en el mes actual</h2>
          <p class="cantidad_total text-2xl font-bold">
            <?php echo $cantidadesAdministador['incidencias_mes_actual']; ?>
          </p>
        </div>

        <!-- Card de Mototaxis -->
        <div class="card bg-white p-6 rounded-lg shadow-lg text-center">
          <!-- <div class="logoCard mb-4">
            <img src="./public/assets/mototaxi.png" class="mx-auto" alt="Imagen de la tarjeta">
          </div> -->
          <!-- Cantidad Unidades -->
          <h2 class="tituloReporte text-xl font-semibold mb-2">Incidencias Pendientes</h2>
          <p class="cantidad_total text-2xl font-bold">
            <?php echo $cantidadesAdministador['recepciones_mes_actual']; ?>
          </p>
        </div>

        <!-- Card de Papeletas Sin Pagar -->
        <div class="card bg-white p-6 rounded-lg shadow-lg text-center">
          <!-- <div class="logoCard mb-4">
            <img src="./public/assets/papeleta.png" class="mx-auto" alt="Imagen de la tarjeta">
          </div> -->
          <!-- Cantidad Papeletas Sin Pagar -->
          <h2 class="tituloReporte text-xl font-semibold mb-2">Incidencias Atendidas</h2>
          <p class="cantidad_total text-2xl font-bold">
            <?php echo $cantidadesAdministador['cierres_mes_actual']; ?>
          </p>
        </div>
      </div>
    </div>
  </main>
</body>
</html>