<?php
require_once 'config/conexion.php';

class AreaModel
{
  private $conector;
  protected $codigoArea;
  protected $nombreArea;

  public function __construct($codigoArea, $nombreArea)
  {
    $this->conector = new Conexion();
    $this->codigoArea = $codigoArea;
    $this->nombreArea = $nombreArea;
  }

  public function registrarArea($nombreArea)
  {
    $conn = $this->conector->getConexion();

    if ($conn != null) {
      try {
        // Preparar la consulta SQL para la inserción sin incluir el campo id
        $sql = "INSERT INTO AREA (ARE_nombre) VALUES (?)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Ejecutar la inserción
        $stmt->execute([$nombreArea]);

        // Obtener el último ID insertado
        $lastId = $conn->lastInsertId();
        return $lastId;
      } catch (PDOException $e) {
        echo "Error al insertar área: " . $e->getMessage();
        return false;
      }
    } else {
      echo "Error de conexión con la base de datos.";
      return false;
    }
  }
  public function listarArea()
  {
    try {
      $conn = $this->conector->getConexion();
      if ($conn != null) {
        $sql = "SELECT CAT_codigo, CAT_descripcion FROM Categoria";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Obtener todos los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las categorías: " . $e->getMessage());
    }
  }

  public function obtenerAreaPorId($codigoArea)
  {
    $conn = $this->conector->getConexion();

    if ($conn != null) {
      try {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = " SELECT * FROM Area  WHERE ARE_codigo = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$codigoArea]);

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los registros obtenidos
        return $registros;
      } catch (PDOException $e) {
        // Manejar cualquier excepción o error que pueda surgir al ejecutar la consulta
        echo "Error al obtener los registros de incidencias: " . $e->getMessage();
        return null;
      }
    } else {
      echo "Error de conexión cierre Controller la base de datos.";
      return null;
    }
  }
}
