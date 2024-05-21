<?php
require_once '../config/conexion.php';

class ImpactoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function getImpactoData()
    {
        $query = "SELECT * FROM IMPACTO";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}
$impactoModel = new ImpactoModel();
$impactos = $impactoModel->getImpactoData();

header('Content-Type: application/json');
echo json_encode($impactos);