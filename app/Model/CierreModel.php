<?php
require_once 'config/conexion.php';

class CierreModel extends Conexion
{

  public function __construct()
  {
    parent::__construct();
  }

  //TODO: Metodo para obtener cierres por ID
  public function obtenerCierrePorID($CieNumero)
  {
    $conector = parent::getConexion();
    try {
      $sql = "SELECT * FROM CIERRE c 
      WHERE CIE_numero = ?";
      $stmt = $conector->prepare($sql);
      $stmt->execute(([$CieNumero]));
      $registros = $stmt->fetch(PDO::FETCH_ASSOC);
      return $registros;
    } catch (PDOException $e) {
      echo "Error al obtener los registros de los cierres: " . $e->getMessage();
      return null;
    }
  }

  //TODO: Metodo para insertar Cierre
  public function insertarCierre($fecha, $hora, $diagnostico, $documento, $asunto, $solucion, $recomendaciones, $operatividad, $recepcion, $usuario)
  {
    $conector = parent::getConexion();
    try {
      if ($conector != null) {
        $sql = "EXEC sp_InsertarCierreActualizarRecepcion @CIE_fecha = :fecha, @CIE_hora = :hora, @CIE_diagnostico = :diagnostico, @CIE_documento = :documento, @CIE_asunto = :asunto, @CIE_solucion = :solucion, @CIE_recomendaciones = :recomendaciones, @OPE_codigo = :operatividad, @REC_numero = :recepcion, @USU_codigo = :usuario";
        $stmt = $conector->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':diagnostico', $diagnostico);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':asunto', $asunto);
        $stmt->bindParam(':solucion', $solucion);
        $stmt->bindParam(':recomendaciones', $recomendaciones);
        $stmt->bindParam(':operatividad', $operatividad);
        $stmt->bindParam(':recepcion', $recepcion);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $conector->lastInsertId();
      } else {
        throw new Exception("Error de conexión a la base de datos.");
      }
    } catch (PDOException $e) {
      echo "Error al insertar el cierre: " . $e->getMessage();
      return false;
    }
  }


  //TODO: Metodo para obtener los cierres registrados
  public function obtenerCierresRegistrados()
  {
    $conector = parent::getConexion();
    try {
      if ($conector != null) {
        $sql = "";
        $stmt = $conector->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } else {
        throw new Exception("Error de conexión a la base de datos.");
      }
    } catch (PDOException $e) {
      echo "Error al obtener cierres registrados: " . $e->getMessage();
      return false;
    }
  }

  //TODO: Metodo para obtener c
}
