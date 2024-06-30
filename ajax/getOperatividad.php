<?php
require_once '../config/conexion.php';

class OperatividadModel extends Conexion
{
  public function __construct()
  {
    parent::__construct();
  }

  //TODO: Metodo para cargar las prioridades
  public function getOperatividadData()
  {
    $conector = parent::getConexion();
    try {
      $query = "SELECT * FROM OPERATIVIDAD ORDER BY OPE_codigo";
      $stmt = $conector->prepare($query);
      $stmt->execute();
      $resultado = $stmt->fetchAll(); // Asegúrate de usar FETCH_ASSOC para obtener un array asociativo
      return $resultado;
    } catch (PDOException $e) {
      echo "Error al cargar datos del modelo opeartividad" . $e->getMessage();
      return null;
    }
  }
}

$operatividadModel = new OperatividadModel();
$operatividades = $operatividadModel->getOperatividadData();

header('Content-Type: application/json');
echo json_encode($operatividades);
