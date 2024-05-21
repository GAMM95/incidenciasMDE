<?php
// Importamos las credenciales y la clase de conexión
require_once 'config/conexion.php';

class PersonaModel extends Conexion
{
  protected $dni;
  protected $nombres;
  protected $apellidoPaterno;
  protected $apellidoMaterno;
  protected $email;
  protected $celular;

  public function __construct(
    $dni,
    $nombres,
    $apellidoPaterno,
    $apellidoMaterno,
    $email,
    $celular
  ) {
    // Llama al constructor de la clase padre (Conexion)
    parent::__construct();

    // Asigna los valores a las propiedades
    $this->dni = $dni;
    $this->nombres = $nombres;
    $this->apellidoPaterno = $apellidoPaterno;
    $this->apellidoMaterno = $apellidoMaterno;
    $this->email = $email;
    $this->celular = $celular;
  }

  // Método para listar personas
  public function listarPersona()
  {
    try {
      $conector = $this->getConexion();

      if ($conector) {
        $sql = "SELECT * FROM PERSONA";
        $stmt = $conector->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      } else {
        throw new Exception("Error de conexión a la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las personas: " . $e->getMessage());
    }
  }

  // Metodo para registrar nueva persona
  public function registrarPersona($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular)
  {
    try {
      $conector = $this->getConexion();
      // Verificar la conexión
      if (!$conector) {
        throw new Exception("Error de conexión a la base de datos.");
      }

      // Preparar la consulta SQL para la inserción
      $sql = "INSERT INTO PERSONA (PER_DNI, PER_nombres, PER_apellidoPaterno, PER_apellidoMaterno, PER_email, PER_celular) VALUES (?, ?, ?, ?, ?, ?)";

      // Preparar la sentencia
      $stmt = $conector->prepare($sql);

      // Ejecutar la inserción
      $success = $stmt->execute([$dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular]);

      if ($success) {
        // Devolver el último ID insertado
        return $conector->lastInsertId();
      } else {
        return false;
      }
    } catch (PDOException $e) {
      throw new Exception("Error al registrar nueva persona: " . $e->getMessage());
    }
  }

  // Metodo para obtener a las personas por ID
  public function obtenerPersonaPorId($CodPersona)
  {
    try {
      $conector = $this->getConexion();
      if ($conector) {
        // Preparar la consulta SQL para obtener los registros de incidencias
        $sql = "SELECT * FROM PERSONA WHERE PER_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute([$CodPersona]);

        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los registros obtenidos
        return $registros;
      } else {
        throw new Exception("Error de conexión cierre Controller la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener los registros de incidencias: " . $e->getMessage());
    }
  }

  // Metodo para actualizar datos de las personas registradas
  public function actualizarPersona($CodPersona, $dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular)
  {
    try {
      $conector = $this->getConexion();
      if ($conector) {
        // Preparar la consulta SQL para la inserción sin incluir el campo id
        $sql = "UPDATE Persona SET PER_dni = ?, PER_nombres = ? , PER_apellidoPaterno = ?, PER_apellidoMaterno = ?, PER_email = ?, PER_celular = ? WHERE PER_codigo = ?";

        // Preparar la sentencia
        $stmt = $conector->prepare($sql);

        // Ejecutar la inserción sin proporcionar el valor para el campo id
        $success = $stmt->execute([
          $dni,
          $nombres,
          $apellidoPaterno,
          $apellidoMaterno,
          $email,
          $celular,
          $CodPersona
        ]);

        if ($success) {
          return true;
        } else {
          return false;
        }
      } else {
        throw new Exception("Error de conexión cierreController la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al actualizar la persona: " . $e->getMessage());
    }
  }
}
