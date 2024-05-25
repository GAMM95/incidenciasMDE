<?php
require_once 'config/conexion.php';
require_once 'AreaModel.php';
require_once 'CategoriaModel.php';
require_once 'UsuarioModel.php';

class IncidenciaModel
{
  private $conector;
  protected $numeroIncidencia;
  protected $fechaIncidencia;
  protected $horaIncidencia;
  protected $descripcionIncidencia;
  protected $codigoPatrimonial;
  protected $asuntoIncidencia;
  protected $area;
  protected $categoria;
  protected $usuario;

  public function __construct($area = null, $categoria = null, $usuario = null)
  {
    $this->conector = new Conexion();
    $this->area = $area;
    $this->categoria = $categoria;
    $this->usuario = $usuario;
  }

  public function obtenerIncidenciaPorId($INC_codigo)
  {
    $conector = $this->conector->getConexion();

    if ($conector != null) {
      try {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = "SELECT * FROM Incidencia i INNER JOIN Categoria c ON i.CAT_codigo = c.CAT_codigo WHERE INC_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$INC_codigo]);

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

  public function registrarIncidencia($fechaIncidencia, $horaIncidencia, $descripcionIncidencia, $codigoPatrimonial, $asuntoIncidencia, $codigoArea, $codigoUsuario, $codigoCategoria)
  {
    $conector = $this->conector->getConexion();

    if ($conector != null) {
      try {
        $sql = "INSERT INTO Incidencia (INC_fecha, INC_hora, INC_descripcion, INC_codigoPatrimonial, INC_asunto, ARE_codigo, USU_codigo, CAT_codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conector->prepare($sql);
        $stmt->execute([$fechaIncidencia, $horaIncidencia, $descripcionIncidencia, $codigoPatrimonial, $asuntoIncidencia, $codigoArea, $codigoUsuario, $codigoCategoria]);
        $lastId = $conector->lastInsertId();
        return $lastId;
      } catch (PDOException $e) {
        echo "Error al registrar la incidencia: " . $e->getMessage();
        return false;
      }
    } else {
      echo "Error de conexión con la base de datos.";
      return false;
    }
  }

  public function listarIncidencias()
  {
    try {
      $conector = $this->conector->getConexion();
      if ($conector != null) {
        $sql = "SELECT NumIncidencia, CodPatrimonial, DescripcionCategoria, FechaIncidencia, Asunto, a.NombreArea, Descripcion, NumDocumento, Hora
      FROM INCIDENCIA i
      INNER JOIN Categoria ON i.CodCategoria = Categoria.CodCategoria
      inner join area a on a.CodArea = i.CodArea";

        $stmt = $conector->prepare($sql);
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


  public function consultarIncidencia($area, $fechaIncidencia)
  {
    try {
      $conector = $this->conector->getConexion();
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
