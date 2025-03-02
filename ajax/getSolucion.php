<?php
require_once '../config/conexion.php';

class SolucionModel extends Conexion
{
  public function __construct()
  {
    parent::__construct();
  }

  // Metodo para cargar operatividad
  public function getSolucionData()
  {
    $conector = parent::getConexion();
    $query = "SELECT * FROM SOLUCION 
      WHERE EST_codigo <> 2
      ORDER BY SOL_descripcion";
    $stmt = $conector->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
  }
}

$solucionModel = new SolucionModel();
$soluciones = $solucionModel->getSolucionData();

// Construir la respuesta en el formato adecuado
$response = [
  'success' => true,
  'soluciones' => []
];

// Mapear los datos a un formato legible por el front-end
foreach ($soluciones as $solucion) {
  $response['soluciones'][] = [
    'codigo' => $solucion['SOL_codigo'],
    'descripcion' => $solucion['SOL_descripcion']
  ];
}

header('Content-Type: application/json');
echo json_encode($response);
