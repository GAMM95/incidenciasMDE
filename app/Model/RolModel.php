<?php
// Importamos las credenciales y la clase de conexión
require_once 'config/conexion.php';
class RolModel extends Conexion
{
  protected $codigo;
  protected $nombre;

  public function __construct($nombre = null)
  {
    parent::__construct();
    $this->nombre = $nombre;
  }

  // Metodo para registrar nuevo rol
  // Método para registrar categorías
  public function registrarRol()
  {
    if ($this->nombre === null) {
      throw new Exception("El nombre del rol no puede estar vacío.");
    }
    try {
      $conector = $this->getConexion();
      $sql = "INSERT INTO Rol (ROL_nombre) VALUE (?)";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$this->nombre]);
      return $conector->lastInsertId();
    } catch (PDOException $e) {
      throw new Exception("Error al insertar la categoría: " . $e->getMessage());
    }
  }

  // MEtodo para listarRoles
  public function listarRol()
  {
    try {
      $conector = $this->getConexion();
      $sql = "SELECT* FROM ROL";
      $stmt = $conector->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Error al obtener los roles: " . $e->getMessage());
    }
  }

  // Metodo para editar roles
  public function editarRol($nombre)
  {
    try {
      $conector = $this->getConexion();
      if ($conector) {
        $sql = "UPDATE Rol SET ROL_nombre = ? WHERE ROL_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la inserción sin proporcionar el valor para el campo id
        $success = $stmt->execute([$nombre]);

        if ($success) {
          return true;
        } else {
          return false;
        }
      } else {
        throw new Exception("Error de conexion");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al actualizar el rol: " . $e->getMessage());
    }
  }

  // Metodo para obtener rol por id
  public function obtenerRolPorId($codigo)
  {
    try {
      $conector = $this->getConexion();
      if ($conector) {
        $query = "SELECT * FROM Rol WHERE ROL_codigo = ?";

        //Preparar la sentencia
        $stmt = $conector->prepare($query);
        // Ejecutar la consulta
        $stmt->execute([$codigo]);

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los registros obtenidos
        return $registros;
      } else {
        throw new Exception("Error de conexión cierre Controller la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener los registros de los roles: " . $e->getMessage());
    }
  }
}
