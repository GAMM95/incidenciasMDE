<?php
// Importar el modelo IncidenciaModel.php
require 'app/Model/IncidenciaModel.php';
require 'app/Model/BienModel.php';
$area = $_SESSION['codigoArea'];
// Obtener el año actual
$anio = date('Y'); // Esto devuelve el año actual en formato "YYYY"

class IncidenciaController
{
  private $incidenciaModel;
  private $bienModel;

  public function __construct()
  {
    $this->incidenciaModel = new IncidenciaModel();
    $this->bienModel = new BienModel();
  }


  // Método de controlador para registrar una incidencia - ADMINISTRADOR 
  public function registrarIncidenciaAdministrador()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $fecha = $_POST['fecha_incidencia'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $asunto = $_POST['asunto'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $codigoPatrimonial = $_POST['codigoPatrimonial'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $area = $_POST['area'] ?? null;
      $usuario = $_POST['usuario'] ?? null;

      try {
        // Validar existencia del bien
        if (!$this->bienModel->validarBienExistente($codigoPatrimonial)) {
          echo json_encode([
            'success' => false,
            'message' => 'Verificar c&oacute;digo patrimonial ingresado.'
          ]);
          exit();
        }

        // Validar que el código patrimonial sea nulo o tenga 12 dígitos
        if (!empty($codigoPatrimonial) && strlen($codigoPatrimonial) !== 12) {
          echo json_encode([
            'success' => false,
            'message' => 'Debe ingresar los 12 d&iacute;gitos del c&oacute;digo patrimonial.'
          ]);
          exit();
        }

        // Llamar al método del modelo para insertar la incidencia en la base de datos
        $insertSuccessId = $this->incidenciaModel->insertarIncidencia($fecha, $hora, $asunto, $descripcion, $documento, $codigoPatrimonial, $categoria, $area, $usuario);

        if ($insertSuccessId) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia registrada.',
            'INC_numero' => $insertSuccessId
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'Error al registrar la incidencia.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    }
  }


  // Controlador para desactivar incidencia en caso de una incidencia falsa
  public function desactivarIncidencia()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigoIncidencia = isset($_POST['numero_incidencia']) ? $_POST['numero_incidencia'] : '';

      try {
        $resultados = $this->incidenciaModel->desactivarIncidencia($codigoIncidencia);
        if ($resultados) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia desactivada.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se pudo desactivar la incidencia.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'M&eacute;todo no permitido.'
      ]);
    }
  }

  // Controlador para desactivar incidencia en caso de una incidencia falsa
  public function activarIncidencia()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigoIncidencia = isset($_POST['numero_incidencia']) ? $_POST['numero_incidencia'] : '';

      try {
        $resultados = $this->incidenciaModel->activarIncidencia($codigoIncidencia);
        if ($resultados) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia activada.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se pudo activar la incidencia.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'M&eacute;todo no permitido.'
      ]);
    }
  }

  // Método de controlador para registrar una incidencia - USUARIO.
  public function registrarIncidenciaUsuario()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $fecha = $_POST['fecha_incidencia'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $asunto = $_POST['asunto'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $codigoPatrimonial = $_POST['codigoPatrimonial'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $area = $_POST['codigoArea'] ?? null;
      $usuario = $_POST['codigoUsuario'] ?? null;

      try {

        // Validar existencia del bien
        if (!$this->bienModel->validarBienExistente($codigoPatrimonial)) {
          echo json_encode([
            'success' => false,
            'message' => 'Verificar c&oacute;digo patrimonial ingresado'
          ]);
          exit();
        }

        // Validar que el código patrimonial sea nulo o tenga 12 dígitos
        if (!empty($codigoPatrimonial) && strlen($codigoPatrimonial) !== 12) {
          echo json_encode([
            'success' => false,
            'message' => 'Debe ingresar los 12 d&iacute;gitos del c&oacute;digo patrimonial.'
          ]);
          exit();
        }

        // Llamar al método del modelo para insertar la incidencia en la base de datos
        $insertSuccessId = $this->incidenciaModel->insertarIncidencia($fecha, $hora, $asunto, $descripcion, $documento, $codigoPatrimonial, $categoria, $area, $usuario);

        if ($insertSuccessId) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia registrada.',
            'INC_numero' => $insertSuccessId
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'Error al registrar la incidencia.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    }
  }

  // Metodo para actualizar indicencias - ADMINISTRADOR
  public function actualizarIncidenciaAdministrador()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Obtener y validar los parámetros
      $numeroIncidencia = $_POST['numero_incidencia'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $area = $_POST['area'] ?? null;
      $codigoPatrimonial = $_POST['codigoPatrimonial'] ?? null;
      $asunto = $_POST['asunto'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;

      header('Content-Type: application/json');
      try {

        if (is_null($asunto) || is_null($documento)) {
          // Respuesta en caso de parámetros faltantes
          echo json_encode([
            'success' => true,
            'message' => 'Faltan parámetros requeridos.'
          ]);
          exit();
        }

        // Validar que el código patrimonial sea nulo o tenga 12 dígitos
        if (!empty($codigoPatrimonial) && strlen($codigoPatrimonial) !== 12) {
          echo json_encode([
            'success' => false,
            'message' => 'Debe ingresar los 12 d&iacute;gitos del c&oacute;digo patrimonial.'
          ]);
          exit();
        }

        // Verificar el estado de la incidencia
        $estado = $this->incidenciaModel->obtenerEstadoIncidencia($numeroIncidencia);

        if ($estado === 3) {
          // Estado permitido para actualización
          echo json_encode([
            'success' => false,
            'message' => 'La incidencia no est&aacute; estado ABIERTO y no puede ser actualizada.'
          ]);
          exit();
        }

        // Llamar al modelo para actualizar la incidencia
        $updateSuccess = $this->incidenciaModel->editarIncidenciaAdmin($numeroIncidencia, $categoria, $area, $codigoPatrimonial, $asunto, $documento, $descripcion);

        if ($updateSuccess) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia actualizada.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se realiz&oacute; ninguna actualizaci&oacute;n.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    }
  }

  // Metodo para actualizar indicencias - ADMINISTRADOR
  public function actualizarIncidenciaUsuario()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Obtener y validar los parámetros
      $numeroIncidencia = $_POST['numero_incidencia'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $codigoPatrimonial = $_POST['codigoPatrimonial'] ?? null;
      $asunto = $_POST['asunto'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;

      header('Content-Type: application/json');
      try {

        if (is_null($asunto) || is_null($documento)) {
          // Respuesta en caso de parámetros faltantes
          echo json_encode([
            'success' => true,
            'message' => 'Faltan par&aacute;metros requeridos.'
          ]);
          exit();
        }

        // Validar que el código patrimonial sea nulo o tenga 12 dígitos
        if (!empty($codigoPatrimonial) && strlen($codigoPatrimonial) !== 12) {
          echo json_encode([
            'success' => false,
            'message' => 'Debe ingresar los 12 d&iacute;gitos del c&oacute;digo patrimonial.'
          ]);
          exit();
        }

        // Verificar el estado de la incidencia
        $estado = $this->incidenciaModel->obtenerEstadoIncidencia($numeroIncidencia);

        if ($estado === 3) {
          // Estado permitido para actualización
          echo json_encode([
            'success' => false,
            'message' => 'La incidencia no est&aacute; estado ABIERTO y no puede ser actualizada.'
          ]);
          exit();
        }

        // Llamar al modelo para actualizar la incidencia
        $updateSuccess = $this->incidenciaModel->editarIncidenciaUser($numeroIncidencia, $categoria, $codigoPatrimonial, $asunto, $documento, $descripcion);

        if ($updateSuccess) {
          echo json_encode([
            'success' => true,
            'message' => 'Incidencia actualizada.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se realiz&oacute; ninguna actualizaci&oacute;n.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    }
  }

  // Método de controlador para consultar incidencias filtradas - ADMINISTRADOR
  public function consultarIncidenciasPendientesAdministrador($area = NULL, $estado = null, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $area = isset($_GET['area']) ? (int) $_GET['area'] : null;
      $estado = isset($_GET['estado']) ? (int) $_GET['estado'] : null;
      $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
      $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;
      error_log("Área: $area, Estado: $estado, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, estado y fecha
      $consultaIncidencia = $this->incidenciaModel->buscarIncidenciasPendientesAdministrador($area, $estado, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaIncidencia;
    }
  }

  // Método de controlador para consultar las incidencias totales - ADMINISTRADOR
  public function consultarIncidenciasTotales($area = NULL, $codigoPatrimonial = null, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $area = isset($_GET['area']) ? (int) $_GET['area'] : null;
      $codigoPatrimonial = isset($_GET['codigoPatrimonial']) ? (int) $_GET['codigoPatrimonial'] : null;
      $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
      $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;
      error_log("Área: $area, Codigo patrimonial: $codigoPatrimonial, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, código patrimonial y fecha
      $consultaIncidencia = $this->incidenciaModel->buscarIncidenciaTotales($area, $codigoPatrimonial, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaIncidencia;
    }
  }

  // Metodo para filtrar incidencias totales por fecha ingresada
  public function filtrarIncidenciasTotalesFecha($fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $fechaInicio = isset($_GET['fechaInicioIncidenciasTotales']) ? $_GET['fechaInicioIncidenciasTotales'] : null;
      $fechaFin = isset($_GET['fechaFinIncidenciasTotales']) ? $_GET['fechaFinIncidenciasTotales'] : null;
      error_log("Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por fecha
      $consultaIncidencia = $this->incidenciaModel->buscarIncidenciaTotalesFecha($fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaIncidencia;
    }
  }

  // Método de controlador para consultar incidencias filtradas - USUARIO
  public function consultarIncidenciaUsuario($area = NULL, $codigoPatrimonial = null, $estado = null, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $area = isset($_GET['codigoArea']) ? (int) $_GET['codigoArea'] : null;
      $codigoPatrimonial = isset($_GET['codigoPatrimonial']) ? $_GET['codigoPatrimonial'] : null;
      $estado = isset($_GET['estado']) ? (int) $_GET['estado'] : null;
      $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
      $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;
      error_log("Área: $area, Estado: $estado, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, estado y fecha
      $consultaIncidencia = $this->incidenciaModel->buscarIncidenciaUsuario($area,  $codigoPatrimonial, $estado, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaIncidencia;
    }
  }

  // Metodo para filtrar incidencias por area para el reporte
  public function filtrarIncidenciasArea($area = NULL, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $area = isset($_GET['areaIncidencia']) ? (int) $_GET['areaIncidencia'] : null;
      $fechaInicio = isset($_GET['fechaInicioIncidenciasArea']) ? $_GET['fechaInicioIncidenciasArea'] : null;
      $fechaFin = isset($_GET['fechaFinIncidenciasArea']) ? $_GET['fechaFinIncidenciasArea'] : null;
      error_log("Area: $area, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, estado y fecha
      $resultado = $this->incidenciaModel->buscarIncidenciasArea($area, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $resultado;
    }
  }

  // Metodo para filtrar incidencias por equipo para el reporte
  public function filtrarIncidenciasEquipo($equipo = NULL, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $equipo = isset($_GET['codigoPatrimonialEquipo']) ? $_GET['codigoPatrimonialEquipo'] : null;
      $fechaInicio = isset($_GET['fechaInicioIncidenciasEquipo']) ? $_GET['fechaInicioIncidenciasEquipo'] : null;
      $fechaFin = isset($_GET['fechaFinIncidenciasEquipo']) ? $_GET['fechaFinIncidenciasEquipo'] : null;
      error_log("Equipo: $equipo, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, estado y fecha
      $resultado = $this->incidenciaModel->buscarIncidenciasEquipo($equipo, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $resultado;
    }
  }

  // Metodo para listar incidencias totales para reporte
  public function listarIncidenciasTotales()
  {
    $resultado = $this->incidenciaModel->listarIncidenciasTotales();
    return $resultado;
  }

  // Metodo para listar incidencias con reporte detalle por area
  public function listarIncidenciasDetalleArea($area)
  {
    $resultado = $this->incidenciaModel->listarIncidenciasDetalleArea($area);
    return $resultado;
  }

  public function listarIncidenciasArea()
  {
    $resultado = $this->incidenciaModel->listarIncidenciasArea();
    return $resultado;
  }

  // Metodo para listar incidencias con codigo patrimonial
  public function listarIncidenciasEquipos()
  {
    $resultado = $this->incidenciaModel->listarIncidenciasEquipos();
    return $resultado;
  }

  // Metodo para filtrar incidencias por area para el reporte
  public function filtrarEquiposMasAfectados($codigoPatrimonial = NULL, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $codigoPatrimonial = isset($_GET['codigoEquipo']) ? $_GET['codigoEquipo'] : null;
      $fechaInicio = isset($_GET['fechaInicioIncidenciasEquipos']) ? $_GET['fechaInicioIncidenciasEquipos'] : null;
      $fechaFin = isset($_GET['fechaFinIncidenciasEquipos']) ? $_GET['fechaFinIncidenciasEquipos'] : null;
      error_log("Equipo: $codigoPatrimonial, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");

      try {
        // Validar existencia del bien
        if (!$this->bienModel->validarBienExistente($codigoPatrimonial)) {
          echo json_encode([
            'success' => false,
            'message' => 'Verificar c&oacute;digo patrimonial ingresado.'
          ]);
          exit();
        }

        // Validar que el código patrimonial sea nulo o tenga 12 dígitos
        if (!empty($codigoPatrimonial) && strlen($codigoPatrimonial) !== 12) {
          echo json_encode([
            'success' => false,
            'message' => 'Debe ingresar los 12 d&iacute;gitos del c&oacute;digo patrimonial.'
          ]);
          exit();
        }
        // Llamar al método para consultar incidencias por área, estado y fecha
        $resultado = $this->incidenciaModel->buscarEquiposMasAfectados($codigoPatrimonial, $fechaInicio, $fechaFin);
        // Retornar el resultado de la consulta
        return $resultado;
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    }
  }

  // Metodo para listar las equipos con mas incidencias
  public function listarEquiposMasAfectados()
  {
    $resultado = $this->incidenciaModel->listarEquiposMasAfectados();
    return $resultado;
  }

  // Metodo para filtrar incidencias por area para el reporte
  public function filtrarAreasMasAfectadas($categoria = NULL, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $categoria = isset($_GET['categoriaSeleccionada']) ? (int) $_GET['categoriaSeleccionada'] : null;
      $fechaInicio = isset($_GET['fechaInicioAreaMasAfectada']) ? $_GET['fechaInicioAreaMasAfectada'] : null;
      $fechaFin = isset($_GET['fechaFinAreaMasAfectada']) ? $_GET['fechaFinAreaMasAfectada'] : null;
      error_log("Categoria: $categoria, Fecha Inicio: $fechaInicio, Fecha Fin: $fechaFin");
      // Llamar al método para consultar incidencias por área, estado y fecha
      $resultado = $this->incidenciaModel->buscarAreasMasAfectadas($categoria, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $resultado;
    }
  }

  // Metodo para listar las areas con mas incidencias
  public function listarAreasMasAfectadas()
  {
    $resultado = $this->incidenciaModel->listarAreasMasAfectadas();
    return $resultado;
  }

  // Metodo para listar el total de incidencias para consulta de administrador
  public function listarIncidenciasTotalesAdministrador()
  {
    $resultado = $this->incidenciaModel->listarIncidenciasTotalesAdministrador();
    return $resultado;
  }

  // Metodo para listar incidencias pendientes para consulta de administrador
  public function listarIncidenciasPendientesAdministrador()
  {
    $resultado = $this->incidenciaModel->listarIncidenciasPendientesAdministrador();
    return $resultado;
  }

  // Metodo para listar incidencias totales por cada area para los usuarios
  public function listarIncidenciasTotalesPorArea($area)
  {
    try {
      // Llamada al modelo para obtener las incidencias
      $resultado = $this->incidenciaModel->listarIncidenciasUsuario($area);
      return $resultado;
    } catch (Exception $e) {
      // Manejo de errores
      echo "Error al listar incidencias: " . $e->getMessage();
    }
  }

  // Metodo para contar incidencias registradas en el formulario de administrador / soporte
  public function contarIncidenciasRegistradas()
  {
    try {
      // Llamada al modelo para obtener las incidencias
      $resultado = $this->incidenciaModel->contarIncidenciasAdministrador();
      return $resultado;
    } catch (Exception $e) {
      // Manejo de errores
      echo "Error al contar incidencias registradas: " . $e->getMessage();
    }
  }

  // Metodo para listar incidencias registradas en el formulario de administrador / soporte
  public function listarIncidenciasRegistradas()
  {
    try {
      // Llamada al modelo para obtener las incidencias
      $resultado = $this->incidenciaModel->listarIncidenciasRegistroAdmin();
      return $resultado;
    } catch (Exception $e) {
      // Manejo de errores
      echo "Error al listar incidencias registradas: " . $e->getMessage();
    }
  }

  // Metodo para listar incidencias registradas por el usuario de una area especifica
  public function listarIncidenciasRegistradasPorUsuario($area = null)
  {
    try {
      // Llamada al modelo para obtener las incidencias
      $resultado = $this->incidenciaModel->listarIncidenciasRegistroUsuario($area);
      return $resultado;
    } catch (Exception $e) {
      // Manejo de errores
      echo "Error al listar incidencias registradas: " . $e->getMessage();
    }
  }

  // Metodo para listar las incidencias registradas
  public function listarIncidenciasRegistradasPaginas($start = null, $limit = null)
  {
    try {
      $resultado = $this->incidenciaModel->listarIncidenciasRecepcion($start, $limit);
      return $resultado;
    } catch (Exception $e) {
      // Manejo de errores
      echo "Error al listar incidencias registradas para paginacion: " . $e->getMessage();
    }
  }

  // Metodo para listar los registros de incidencias en la tabla auditoria
  public function listarEventosIncidencias()
  {
    $resultadoAuditoriaIncidencias = $this->incidenciaModel->listarEventosIncidencias();
    return $resultadoAuditoriaIncidencias;
  }

  // Metodo para mostrar notificaciones de nuevas incidencias al administrador
  public function mostrarNotificacionesIncidenciasAdmin()
  {
    $resultadoIncidencias = $this->incidenciaModel->notificacionesAdmin();
    return $resultadoIncidencias;
  }

  // Metodo para consultar eventos de incidencias - auditoria
  public function consultarEventosIncidencias($usuario = null, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $usuario = isset($_GET['usuarioEventoIncidencias']) ? (int) $_GET['usuarioEventoIncidencias'] : null;
      $fechaInicio = isset($_GET['fechaInicioEventosIncidencias']) ? $_GET['fechaInicioEventosIncidencias'] : null;
      $fechaFin = isset($_GET['fechaFinEventosIncidencias']) ? $_GET['fechaFinEventosIncidencias'] : null;
      // Llamar al método para consultar incidencias por área, código patrimonial y fecha
      $consultaEventosTotales = $this->incidenciaModel->buscarEventosIncidencias($usuario, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaEventosTotales;
    }
  }

  // // Metodo para mostrar las incidencias por cada mes
  // public function mostrarCantidadIncidenciasMes($anio = null)
  // {

  //   try {
  //     $cantidadIncidenciasEnero = $this->incidenciaModel->contarIncidenciasEnero($anio);
  //     $cantidadIncidenciasFebrero = $this->incidenciaModel->contarIncidenciasFebrero($anio);
  //     $cantidadIncidenciasMarzo = $this->incidenciaModel->contarIncidenciasMarzo($anio);
  //     $cantidadIncidenciasAbril = $this->incidenciaModel->contarIncidenciasAbril($anio);
  //     $cantidadIncidenciasMayo = $this->incidenciaModel->contarIncidenciasMayo($anio);
  //     $cantidadIncidenciasJunio = $this->incidenciaModel->contarIncidenciasJunio($anio);
  //     $cantidadIncidenciasJulio = $this->incidenciaModel->contarIncidenciasJulio($anio);
  //     $cantidadIncidenciasAgosto = $this->incidenciaModel->contarIncidenciasAgosto($anio);
  //     $cantidadIncidenciasSetiembre = $this->incidenciaModel->contarIncidenciasSetiembre($anio);
  //     $cantidadIncidenciasOctubre = $this->incidenciaModel->contarIncidenciasOctubre($anio);
  //     $cantidadIncidenciasNoviembre = $this->incidenciaModel->contarIncidenciasNoviembre($anio);
  //     $cantidadIncidenciasDiciembre = $this->incidenciaModel->contarIncidenciasDiciembre($anio);

  //     return [
  //       'incidencias_enero' => $cantidadIncidenciasEnero,
  //       'incidencias_febrero' => $cantidadIncidenciasFebrero,
  //       'incidencias_marzo' => $cantidadIncidenciasMarzo,
  //       'incidencias_abril' => $cantidadIncidenciasAbril,
  //       'incidencias_mayo' => $cantidadIncidenciasMayo,
  //       'incidencias_junio' => $cantidadIncidenciasJunio,
  //       'incidencias_julio' => $cantidadIncidenciasJulio,
  //       'incidencias_agosto' => $cantidadIncidenciasAgosto,
  //       'incidencias_setiembre' => $cantidadIncidenciasSetiembre,
  //       'incidencias_octubre' => $cantidadIncidenciasOctubre,
  //       'incidencias_noviembre' => $cantidadIncidenciasNoviembre,
  //       'incidencias_diciembre' => $cantidadIncidenciasDiciembre
  //     ];
  //   } catch (Exception $e) {
  //     throw new Exception('Error al obtener las cantidades de incidencias mensuales: ' . $e->getMessage());
  //   }
  // }


  // Metodo para mostrar las incidencias por cada mes
  public function mostrarCantidadIncidenciasMes($anio = null)
  {
    try {
      // Si no se pasa un año como parámetro, se usa el año actual
      if ($anio === null) {
        $anio = date('Y'); // Obtener el año actual
      }

      // Obtener la cantidad de incidencias por mes utilizando el año especificado o el actual
      $cantidadIncidenciasEnero = $this->incidenciaModel->contarIncidenciasEnero($anio);
      $cantidadIncidenciasFebrero = $this->incidenciaModel->contarIncidenciasFebrero($anio);
      $cantidadIncidenciasMarzo = $this->incidenciaModel->contarIncidenciasMarzo($anio);
      $cantidadIncidenciasAbril = $this->incidenciaModel->contarIncidenciasAbril($anio);
      $cantidadIncidenciasMayo = $this->incidenciaModel->contarIncidenciasMayo($anio);
      $cantidadIncidenciasJunio = $this->incidenciaModel->contarIncidenciasJunio($anio);
      $cantidadIncidenciasJulio = $this->incidenciaModel->contarIncidenciasJulio($anio);
      $cantidadIncidenciasAgosto = $this->incidenciaModel->contarIncidenciasAgosto($anio);
      $cantidadIncidenciasSetiembre = $this->incidenciaModel->contarIncidenciasSetiembre($anio);
      $cantidadIncidenciasOctubre = $this->incidenciaModel->contarIncidenciasOctubre($anio);
      $cantidadIncidenciasNoviembre = $this->incidenciaModel->contarIncidenciasNoviembre($anio);
      $cantidadIncidenciasDiciembre = $this->incidenciaModel->contarIncidenciasDiciembre($anio);
      $totalIncidenciasAnio = $this->incidenciaModel->contarIncidenciasPorAnio($anio);

      // Retornar los resultados en un array
      return [
        'incidencias_enero' => $cantidadIncidenciasEnero,
        'incidencias_febrero' => $cantidadIncidenciasFebrero,
        'incidencias_marzo' => $cantidadIncidenciasMarzo,
        'incidencias_abril' => $cantidadIncidenciasAbril,
        'incidencias_mayo' => $cantidadIncidenciasMayo,
        'incidencias_junio' => $cantidadIncidenciasJunio,
        'incidencias_julio' => $cantidadIncidenciasJulio,
        'incidencias_agosto' => $cantidadIncidenciasAgosto,
        'incidencias_setiembre' => $cantidadIncidenciasSetiembre,
        'incidencias_octubre' => $cantidadIncidenciasOctubre,
        'incidencias_noviembre' => $cantidadIncidenciasNoviembre,
        'incidencias_diciembre' => $cantidadIncidenciasDiciembre,
        'total_incidencias_anio' => $totalIncidenciasAnio
      ];
    } catch (Exception $e) {
      throw new Exception('Error al obtener las cantidades de incidencias mensuales: ' . $e->getMessage());
    }
  }
}
