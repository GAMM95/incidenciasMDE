<?php
require_once 'config/conexion.php';
require_once 'AreaModel.php';
require_once 'CategoriaModel.php';
require_once 'UsuarioModel.php';

class IncidenciaModel extends Conexion
{
  protected $numeroIncidencia;
  protected $fechaIncidencia;
  protected $horaIncidencia;
  protected $asuntoIncidencia;
  protected $descripcionIncidencia;
  protected $documentoIncidencia;
  protected $codigoPatrimonial;
  protected $estado;
  protected $categoria;
  protected $area;
  protected $usuario;


  public function __construct(
    $numeroIncidencia = null,
    $fechaIncidencia = null,
    $horaIncidencia = null,
    $asuntoIncidencia = null,
    $descripcionIncidencia = null,
    $documentoIncidencia = null,
    $codigoPatrimonial = null,
    $estado = null,
    $categoria = null,
    $area = null,
    $usuario = null,

  ) {
    parent::__construct();
    $this->numeroIncidencia = $numeroIncidencia;
    $this->fechaIncidencia = $fechaIncidencia;
    $this->horaIncidencia = $horaIncidencia;
    $this->asuntoIncidencia = $asuntoIncidencia;
    $this->descripcionIncidencia = $descripcionIncidencia;
    $this->documentoIncidencia = $documentoIncidencia;
    $this->codigoPatrimonial = $codigoPatrimonial;
    $this->estado = $estado;
    $this->categoria = $categoria;
    $this->area = $area;
    $this->usuario = $usuario;
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

  public function registrarIncidencia()
  {


    try {
      $sql = "INSERT INTO INCIDENCIA (INC_fecha, INC_hora, INC_asunto, INC_descripcion, INC_documento, INC_codigoPatrimonial, INC_asunto, ARE_codigo, USU_codigo, CAT_codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$fechaIncidencia, $horaIncidencia, $descripcionIncidencia, $codigoPatrimonial, $asuntoIncidencia, $codigoArea, $codigoUsuario, $codigoCategoria]);
      $lastId = $conector->lastInsertId();
      return $lastId;
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
}
