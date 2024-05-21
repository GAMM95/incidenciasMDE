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
    $conn = $this->conector->getConexion();

    if ($conn != null) {
      try {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = "SELECT * FROM Incidencia i INNER JOIN Categoria c ON i.CAT_codigo = c.CAT_codigo WHERE INC_codigo = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

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
    $conn = $this->conector->getConexion();

    if ($conn != null) {
      try {
        $sql = "INSERT INTO Incidencia (INC_fecha, INC_hora, INC_descripcion, INC_codigoPatrimonial, INC_asunto, ARE_codigo, USU_codigo, CAT_codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fechaIncidencia, $horaIncidencia, $descripcionIncidencia, $codigoPatrimonial, $asuntoIncidencia, $codigoArea, $codigoUsuario, $codigoCategoria]);
        $lastId = $conn->lastInsertId();
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
}
