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
        $query = "SELECT CodPersona, NombrePersona FROM Persona";
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