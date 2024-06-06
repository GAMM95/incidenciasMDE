<?php
require_once '../config/conexion.php';

class PersonaModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function getPersonaData()
    {
        $query = "select (PER_nombres + ' ' + PER_apellidoPaterno +' '+ PER_apellidoMaterno) AS persona from PERSONA";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}

$personaModel = new PersonaModel();
$personas = $personaModel->getPersonaData();

header('Content-Type: application/json');
echo json_encode($personas);