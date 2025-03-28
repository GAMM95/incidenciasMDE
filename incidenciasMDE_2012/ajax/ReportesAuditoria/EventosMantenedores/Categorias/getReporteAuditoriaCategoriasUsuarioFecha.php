  <?php
  require_once '../../../../config/conexion.php';

  class ReporteAuditoriaCategoriasUsuarioFecha extends Conexion
  {
    public function __construct()
    {
      parent::__construct();
    }
    public function getReporteAuditoriaCategoriasUsuarioFecha($usuario, $fechaInicio, $fechaFin)
    {
      $conector = parent::getConexion();
      $sql = "EXEC sp_consultar_eventos_categorias :usuario, :fechaInicio, :fechaFin";
      $stmt = $conector->prepare($sql);
      $stmt->bindParam(':usuario', $usuario);
      $stmt->bindParam(':fechaInicio', $fechaInicio);
      $stmt->bindParam(':fechaFin', $fechaFin);
      try {
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
        exit;
      }
      return $resultado;
    }
  }

  // Validación de los parámetros
  $usuario = isset($_GET['usuarioEventoCategorias']) ? $_GET['usuarioEventoCategorias'] : null;
  $fechaInicio = isset($_GET['fechaInicioEventosCategorias']) ? $_GET['fechaInicioEventosCategorias'] : null;
  $fechaFin = isset($_GET['fechaFinEventosCategorias']) ? $_GET['fechaFinEventosCategorias'] : null;

  $reporteAuditoriaCategoriasUsuarioFecha = new ReporteAuditoriaCategoriasUsuarioFecha();
  $reporte = $reporteAuditoriaCategoriasUsuarioFecha->getReporteAuditoriaCategoriasUsuarioFecha($usuario, $fechaInicio, $fechaFin);

  header('Content-Type: application/json');
  echo json_encode($reporte);
  exit();
