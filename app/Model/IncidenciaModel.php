<?php
require_once 'config/conexion.php';
require_once 'AreaModel.php';
require_once 'CategoriaModel.php';
require_once 'UsuarioModel.php';

class IncidenciaModel extends Conexion
{

  public function __construct()
  {
    parent::__construct();
  }

  public function obtenerIncidenciaPorId($IncNumero)
  {
    try {
      $conector = $this->getConexion();
      $sql = "SELECT * FROM  INCIDENCIA i
      INNER JOIN Categoria c ON i.CAT_codigo = c.CAT_codigo 
      WHERE INC_codigo = ?";

      // Preparar la sentencia
      $stmt = $conector->prepare($sql);

      // Ejecutar la consulta
      $stmt->execute([$IncNumero]);

      // Obtener los resultados como un array asociativo
      $registros = $stmt->fetch(PDO::FETCH_ASSOC);

      // Devolver los registros obtenidos
      return $registros;
    } catch (PDOException $e) {
      // Manejar cualquier excepción o error que pueda surgir al ejecutar la consulta
      echo "Error al obtener los registros de incidencias: " . $e->getMessage();
      return null;
    }
  }

  // TODO: Metodo para registrar incidencias
  public function insertarIncidencia(
    $INC_fecha,
    $INC_hora,
    $INC_asunto,
    $INC_descripcion,
    $INC_documento,
    $INC_codigoPatrimonial,
    $EST_codigo,
    $CAT_codigo,
    $ARE_codigo,
    $USU_codigo
  ) {
    $conector = parent::getConexion();
    try {
      if ($conector != null) {
        $sql = "INSERT INTO INCIDENCIA (INC_fecha, INC_hora, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial,EST_codigo, CAT_codigo, ARE_codigo, USU_codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conector->prepare($sql);
        $success = $stmt->execute([
          $INC_fecha,
          $INC_hora,
          $INC_asunto,
          $INC_descripcion,
          $INC_documento,
          $INC_codigoPatrimonial,
          3,
          $CAT_codigo,
          $ARE_codigo,
          $USU_codigo
        ]);
        if ($success) {
          echo "Error al insertar la incidencia.";
          $lastId = $conector->lastInsertId();
          return $lastId;
        } else {
          return false;
        }
      }
    } catch (PDOException $e) {
      echo "Error al registrar la incidencia: " . $e->getMessage();
      return false;
    }
  }

  public function listarIncidencias()
  {
    try {
      $conector = $this->getConexion();

      $sql = "SELECT INC_numero, CONVERT(VARCHAR(10),INC_fecha, 103) AS INC_fecha,  CONVERT(VARCHAR(5), INC_hora, 108) AS INC_hora, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial
      , c.CAT_nombre, a.ARE_nombre
      FROM INCIDENCIA i
      INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
      INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo";

      $stmt = $conector->prepare($sql);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
    }
  }


  public function consultarIncidencia($area, $fechaIncidencia)
  {
    try {
      $conector = $this->getConexion();
      if ($conector) {
        $sql = "SELECT * FROM Incidencia i 
        INNER JOIN Categoria c ON i.CAT_codigo = c.CAT_codigo
        INNER JOIN Area a ON a.ARE_codigo = i.ARE_codigo
        WHERE (i.INC_fecha = $fechaIncidencia) OR
        (a.ARE_nombre = $area)";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
    }
  }

  public function obtenerIncidenciasSinRecepcionar()
  {
    $conn = parent::getConexion();

    if ($conn != null) {
      try {
        // Preparar la consulta SQL para obtener los registros de incidencias
        // $sql = "SELECT * FROM Incidencia i INNER JOIN Categoria c ON i.CodCategoria = c.CodCategoria WHERE CodEstado = 1";
        $sql = "SELECT INC_numero, CONVERT(VARCHAR(10),INC_fecha, 103) AS INC_fecha,  CONVERT(VARCHAR(5), INC_hora, 108) AS INC_hora, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial
      , c.CAT_nombre, a.ARE_nombre
      FROM INCIDENCIA i
      INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
      INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo
	   WHERE EST_codigo = 3";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
