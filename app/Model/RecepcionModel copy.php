<?php
// Importamos las credenciales y la clase de conexión
require_once 'config/conexion.php';

class RecepcionModel extends Conexion
{
  private $conexion;

  public function __construct()
  {
    parent::__construct();
  }
  //TODO: Metodo para obtener recepcion por ID
  public function obtenerRecepcionPorId($RecNumero)
  {
    try {
      $conector = $this->getConexion();
      $sql = "SELECT * FROM  RECEPCION r
      WHERE REC_numero = ?";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$RecNumero]);
      $registros = $stmt->fetch(PDO::FETCH_ASSOC);
      return $registros;
    } catch (PDOException $e) {
      // Manejar cualquier excepción o error que pueda surgir al ejecutar la consulta
      echo "Error al obtener los registros de incidencias: " . $e->getMessage();
      return null;
    }
  }

  //TODO: Metodo para insertar Recepcion
  // public function insertarRecepcion(
  //   $REC_fecha,
  //   $REC_hora,
  //   $INC_numero,
  //   $PRI_codigo,
  //   $IMP_codigo,
  //   $USU_codigo,
  //   $EST_codigo
  // ) {
  //   $conector = parent::getConexion();
  //   try {
  //     if ($conector != null) {
  //       $sql = "INSERT INTO RECEPCION (REC_fecha, REC_hora, INC_numero, PRI_codigo, IMP_codigo, USU_codigo,EST_codigo) VALUES (?, ?, ?, ?, ?, ?, ?)";
  //       $stmt = $conector->prepare($sql);
  //       $success = $stmt->execute([
  //         $REC_fecha,
  //         $REC_hora,
  //         $INC_numero,
  //         $PRI_codigo,
  //         $IMP_codigo,
  //         $USU_codigo,
  //         4
  //       ]);
  //       if ($success) {
  //         $lastId = $conector->lastInsertId();
  //         return $lastId;
  //       } else {
  //         return false;
  //       }
  //     }
  //   } catch (PDOException $e) {
  //     echo "Error al registrar la recepcion: " . $e->getMessage();
  //     return false;
  //   }
  // }
  public function insertarRecepcion(
    $REC_fecha,
    $REC_hora,
    $INC_numero,
    $PRI_codigo,
    $IMP_codigo,
    $USU_codigo
  ) {
    $conector = parent::getConexion();
    try {
      if ($conector != null) {
        // Llamada al procedimiento almacenado
        $sql = "EXEC sp_InsertarRecepcionYActualizarEstado ?, ?, ?, ?, ?, ?";
        $stmt = $conector->prepare($sql);
        $success = $stmt->execute([
          $REC_fecha,
          $REC_hora,
          $INC_numero,
          $PRI_codigo,
          $IMP_codigo,
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
      echo "Error al registrar la recepción: " . $e->getMessage();
      return false;
    }
  }


  //TODO: Metodo para recepcionar Incidencia
  public function recepcionarIncidencia($NumIncidencia)
  {
    $conn = $this->conexion->getConexion();

    if ($conn != null) {
      // Preparar la consulta SQL para la inserción sin incluir el campo id
      $sql = "UPDATE INCIDENCIA SET EST_codigo = 4 WHERE INC_numero = ?";

      // Preparar la sentencia
      $stmt = $conn->prepare($sql);

      // Ejecutar la inserción sin proporcionar el valor para el campo id
      $success = $stmt->execute(
        [
          $NumIncidencia
        ]
      );

      if ($success) {
        echo "Error al actualizar la incidencia.";
        return $success;
      } else {
        return false;
      }
    } else {
      echo "Error de conexión cierreController la base de datos.";
      return false;
    }
  }

  public function obtenerRecepcionesRegistradas()
  {
    try {
      $conn = $this->conexion->getConexion();

      if ($conn != null) {
        $sql = "SELECT REC_numero, r.INC_numero, i.INC_codigoPatrimonial, i.EST_codigo, 
                P.PRI_nombre, r.REC_fecha, Imp.IMP_codigo
          FROM Recepcion r
          INNER JOIN INCIDENCIA i ON r.INC_numero = i.INC_numero
          INNER JOIN PRIORIDAD p ON r.PRI_codigo = P.PRI_codigo
          INNER JOIN IMPACTO Imp ON r.IMP_codigo = Imp.IMP_codigo 
          WHERE r.EST_codigo = 4
          ORDER BY R.REC_numero";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } else {
        throw new Exception("Error de conexión a la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
    }
  }

  // public function listarRecepcionesRegistradas()
  // //esta funcion es para concultar recepcion
  // {
  //   try {
  //     $conn = $this->conexion->getConexion();

  //     if ($conn != null) {
  //       $sql = "SELECT R.REC_codigo, R.INC_codigo, I.INC_codigoPatrimonial AS codigo_patrimonial, I.INC_estado, 
  //               P.PRI_nombre AS prioridad, R.REC_fecha, INC_asunto, a.ARE_nombre, c.CAT_nombre
  //         FROM Recepcion R
  //         INNER JOIN Incidencia I ON R.INC_codigo = I.INC_codigo
  //         INNER JOIN Prioridad P ON R.PRI_codigo = P.PRI_codigo
  //         INNER JOIN Impacto Imp ON R.IMP_codigo = Imp.IMP_codigo 
  // 	  inner join CATEGORIA c on i.CAT_codigo = c.CAT_codigo
  // 	  inner join area a on i.INC_codigo = a.ARE_codigo

  //         ORDER BY R.REC_codigo";

  //       $stmt = $conn->prepare($sql);
  //       $stmt->execute();

  //       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //       return $result;
  //     } else {
  //       throw new Exception("Error de conexión a la base de datos.");
  //     }
  //   } catch (PDOException $e) {
  //     throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
  //   }
  // }



  public function BuscarRecepcionesRegistradas()
  {
    try {
      $conn = $this->conexion->getConexion();

      if ($conn != null) {
        $sql = "SELECT R.REC_codigo, R.INC_numero, I.INC_codigoPatrimonial AS codigo_patrimonial, I.INC_estado, 
                P.PRI_nombre AS prioridad, R.REC_fecha, Imp.IMP_nombre AS impacto, C.CAT_nombre
          FROM Recepcion R
          INNER JOIN Incidencia I ON R.INC_numero = I.INC_numero
          INNER JOIN Prioridad P ON R.PRI_codigo = P.PRI_codigo
          INNER JOIN Impacto Imp ON R.IMP_codigo = Imp.IMP_codigo 
		  inner join CATEGORIA c on i.CAT_codigo = c.CAT_codigo

          WHERE I.INC_estado != 3 and R.REC_codigo like '1%'
          ORDER BY R.REC_codigo";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } else {
        throw new Exception("Error de conexión a la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
    }
  }
}
