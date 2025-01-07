
<?php
require_once '../../../../config/conexion.php';

class ReporteAuditoriaBienesUsuario extends Conexion
{
  public function __construct()
  {
    parent::__construct();
  }
  public function getReporteAuditoriaBienesUsuario($usuario)
  {
    $conector = parent::getConexion();
    $sql = "EXEC sp_consultar_eventos_bienes :usuario, NULL, NULL";
    $stmt = $conector->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
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
$usuario = isset($_GET['usuarioEventoBienes']) ?  $_GET['usuarioEventoBienes'] : null;

$reporteAuditoriaBienesUsuario = new ReporteAuditoriaBienesUsuario();
$reporte = $reporteAuditoriaBienesUsuario->getReporteAuditoriaBienesUsuario($usuario);

header('Content-Type: application/json');
echo json_encode($reporte);
exit();
