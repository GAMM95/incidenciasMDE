<?php
require_once 'config/conexion.php';

class IncidenciaModel extends Conexion
{

  public function __construct()
  {
    parent::__construct();
  }

  //TODO: Metodo para obtener incidencias por ID
  public function obtenerIncidenciaPorId($IncNumero)
  {
    $conector = parent::getConexion();
    try {
      $sql = "SELECT * FROM  INCIDENCIA i
      INNER JOIN Categoria c ON i.CAT_codigo = c.CAT_codigo 
      WHERE INC_numero = ?";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$IncNumero]);
      $registros = $stmt->fetch(PDO::FETCH_ASSOC);
      return $registros;
    } catch (PDOException $e) {
      echo "Error al obtener los registros de incidencias: " . $e->getMessage();
      return null;
    }
  }

  // TODO: Metodo para insertar incidencias
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
        $sql = "INSERT INTO INCIDENCIA (INC_fecha, INC_hora, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial, EST_codigo, CAT_codigo, ARE_codigo, USU_codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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

  // TODO: Metodo para listar incidencias registradas
  public function listarIncidencias()
  {
    $conector = $this->getConexion();
    try {
      $sql = "SELECT INC_numero, (CONVERT(VARCHAR(10),INC_fecha,103) + ' - '+ CONVERT(VARCHAR(5), INC_hora, 108)) AS fechaIncidenciaFormateada, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial
      , c.CAT_nombre, a.ARE_nombre, u.USU_nombre
      FROM INCIDENCIA i
      INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
      INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo
      INNER JOIN USUARIO u ON u.USU_codigo = i.USU_codigo";
      $stmt = $conector->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
    }
  }

  // TODO: Metodo para consultar incidencias 
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

  //TODO: Metodo para obtener incidencias sin recepcionar
  public function obtenerIncidenciasSinRecepcionar()
  {
    $conn = parent::getConexion();

    if ($conn != null) {
      try {
        $sql = "SELECT INC_numero, (CONVERT(VARCHAR(10),INC_fecha,103) + ' - ' + CONVERT(VARCHAR(5), INC_hora, 108)) AS fechaIncidenciaFormateada, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial, c.CAT_nombre, a.ARE_nombre, u.USU_nombre
        FROM INCIDENCIA i
        INNER JOIN CATEGORIA c ON c.CAT_codigo = i.CAT_codigo
        INNER JOIN AREA a ON a.ARE_codigo = i.ARE_codigo
        INNER JOIN USUARIO u ON u.USU_codigo = i.USU_codigo
        WHERE i.EST_codigo = 3";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
      } catch (PDOException $e) {
        echo "Error al obtener los registros de incidencias sin recepcionar: " . $e->getMessage();
        return null;
      }
    } else {
      echo "Error de conexión cierre Controller la base de datos.";
      return null;
    }
  }
}
