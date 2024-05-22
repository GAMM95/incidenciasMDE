<?php
// require_once 'config/conexion.php';

class CategoriaModel extends Conexion
{
  protected $codigoCategoria;
  protected $descripcionCategoria;

  public function __construct($codigoCategoria, $descripcionCategoria)
  {
    // Llama al constructor de la clase padre (Conexion)
    parent::__construct();

    // Asigna los valores a las propiedades
    $this->codigoCategoria = $codigoCategoria;
    $this->descripcionCategoria = $descripcionCategoria;
  }

  // Método para registrar categorías
  public function registrarCategoria($descripcionCategoria)
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        // Preparar la consulta SQL para la inserción sin incluir el campo id
        $sql = "INSERT INTO CATEGORIA (CAT_nombre) VALUES (?)";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la inserción
        $stmt->execute([$descripcionCategoria]);

        // Obtener el último ID insertado
        $lastId = $conector->lastInsertId();
        return $lastId;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al insertar la categoría: " . $e->getMessage());
    }
  }

  public function listarCategoria()
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        $sql = "SELECT CAT_codigo, CAT_nombre FROM CATEGORIA";
        $stmt = $conector->prepare($sql);
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

  public function obtenerCategoriaPorId($CodCategoria)
  {
    try {
      $conector = $this->getConexion();

      if ($conector != null) {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = " SELECT * FROM CATEGORIA  WHERE CAT_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$CodCategoria]);

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los registros obtenidos
        return $registros;
      } else {
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener los registros de incidencias: " . $e->getMessage());
    }
  }
}
