<?php
require_once '../config/conexion.php';

class PrioridadModel extends Conexion
{
    // private $db;

    public function __construct()
    {
        // $this->db = (new Conexion())->getConexion();
        parent::__construct();
    }

    public function getPrioridadData()
    {
        $conector = parent::getConexion();
        $query = "select * from prioridad
  order by PRI_codigo";
        // $stmt = $this->db->prepare($query);
        $stmt = $conector->prepare($query);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}

$prioridadModel = new PrioridadModel();
$prioridades = $prioridadModel->getPrioridadData();

header('Content-Type: application/json');
echo json_encode($prioridades);
