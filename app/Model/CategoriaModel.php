<?php
require_once 'config/conexion.php';

class CategoriaModel extends Conexion
{
  protected $nombre;

  public function __construct($nombre = null)
  {
    parent::__construct();
    $this->nombre = $nombre;
  }

  // Método para registrar categorías
  public function registrarCategoria()
  {
    if ($this->nombre === null) {
      throw new Exception("El nombre de la categoría no puede estar vacío.");
    }
    try {
      $conector = $this->getConexion();
      $sql = "INSERT INTO CATEGORIA (CAT_nombre) VALUES (?)";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$this->nombre]);
      return $conector->lastInsertId();
    } catch (PDOException $e) {
      throw new Exception("Error al insertar la categoría: " . $e->getMessage());
    }
  }

  // Método para listar categorías
  public function listarCategoria()
  {
    try {
      $conector = $this->getConexion();
      $sql = "SELECT CAT_codigo, CAT_nombre FROM CATEGORIA ORDER BY CAT_codigo ASC";
      $stmt = $conector->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las categorías: " . $e->getMessage());
    }
  }

  // Método para obtener una categoría por su ID
  public function obtenerCategoriaPorId($codigo)
  {
    try {
      $conector = $this->getConexion();
      $sql = "SELECT * FROM CATEGORIA WHERE CAT_codigo = ?";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$codigo]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Error al obtener la categoría: " . $e->getMessage());
    }
  }
}
