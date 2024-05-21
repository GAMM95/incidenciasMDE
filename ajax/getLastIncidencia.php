<?php
require_once '../config/conexion.php';


$db = (new Conexion())->getConexion();
$query = "SELECT TOP 1 * FROM INCIDENCIA ORDER BY INC_codigo DESC";

$stmt = $db->prepare($query);
$stmt->execute();
$resultado = $stmt->fetch();
if (!$resultado) {
    $resultado = array('INC_codigo' => 1);
}
else {
    $resultado = array('INC_codigo' => $resultado['INC_codigo'] + 1);
}
header('Content-Type: application/json');
echo json_encode($resultado);