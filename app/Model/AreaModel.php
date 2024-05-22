<?php
require_once 'config/conexion.php';

class AreaModel extends Conexion
{
  protected $codigoArea;
  protected $nombreArea;

  public function __construct($codigoArea, $nombreArea)
  {
    // Llama al constructor de la clase padre (Conexion)
    parent::__construct();

    // Asigna los valores a las propiedades
    $this->codigoArea = $codigoArea;
    $this->nombreArea = $nombreArea;
  }

  public function registrarArea($nombreArea)
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        // Preparar la consulta SQL para la inserción sin incluir el campo id
        $sql = "INSERT INTO AREA (ARE_nombre) VALUES (?)";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la inserción
        $stmt->execute([$nombreArea]);

        // Obtener el último ID insertado
        $lastId = $conector->lastInsertId();
        return $lastId;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al insertar área: " . $e->getMessage());
    }
  }

  public function listarArea()
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        $sql = "SELECT ARE_codigo, ARE_nombre FROM AREA";
        $stmt = $conector->prepare($sql);
        $stmt->execute();

        // Obtener todos los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las áreas: " . $e->getMessage());
    }
  }

  public function obtenerAreaPorId($codigoArea)
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = " SELECT * FROM Area  WHERE ARE_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$codigoArea]);

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los registros obtenidos
        return $registros;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener el área: " . $e->getMessage());
    }
  }
}
