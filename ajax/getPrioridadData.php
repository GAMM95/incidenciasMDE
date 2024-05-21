<?php
require_once '../config/conexion.php';

class PrioridadModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function getPrioridadData()
    {
        $query = "select * from prioridad
  order by CodPrioridad";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}

$prioridadModel = new PrioridadModel();
$prioridades = $prioridadModel->getPrioridadData();

header('Content-Type: application/json');
echo json_encode($prioridades);