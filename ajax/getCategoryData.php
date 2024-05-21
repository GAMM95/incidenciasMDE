<?php
require_once '../config/conexion.php';

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function getCategoryData()
    {
        $query = "SELECT CAT_codigo, CAT_nombre FROM CATEGORIA"; // Ajusta los nombres de las columnas según tu base de datos
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC); // Asegúrate de usar FETCH_ASSOC para obtener un array asociativo
        return $resultado;
    }
}

$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategoryData();

header('Content-Type: application/json');
echo json_encode($categories);
