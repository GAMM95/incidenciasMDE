<?php
// Importamos las credenciales y la clase de conexión
require_once 'config/conexion.php';

class PersonaModel extends Conexion
{
  protected $codigoPersona;
  protected $dni;
  protected $nombres;
  protected $apellidoPaterno;
  protected $apellidoMaterno;
  protected $email;
  protected $celular;

  public function __construct(
    $codigoPersona = null,
    $dni = null,
    $nombres = null,
    $apellidoPaterno = null,
    $apellidoMaterno = null,
    $email = null,
    $celular = null
  ) {
    // Llama al constructor de la clase padre (Conexion)
    parent::__construct();
    $this->codigoPersona = $codigoPersona;
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
      $sql = "SELECT * FROM PERSONA";
      $stmt = $conector->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Error al obtener las personas: " . $e->getMessage());
    }
  }

  // Metodo para registrar nueva persona
  public function registrarPersona()
  {
    // Validación de los campos
    if ($this->dni === null || trim($this->dni) === '') {
      throw new Exception("El DNI no puede estar vacío");
    }
    if ($this->nombres === null || trim($this->nombres) === '') {
      throw new Exception("Los nombres de la persona no pueden estar vacíos");
    }
    if ($this->apellidoPaterno === null || trim($this->apellidoPaterno) === '') {
      throw new Exception("El apellido paterno no puede estar vacío");
    }
    if ($this->apellidoMaterno === null || trim($this->apellidoMaterno) === '') {
      throw new Exception("El apellido materno no puede estar vacío");
    }
    if ($this->celular === null || trim($this->celular) === '') {
      throw new Exception("El celular no puede estar vacío");
    }
    if ($this->email === null || trim($this->email) === '') {
      throw new Exception("El email no puede estar vacío");
    }

    try {
      $conector = $this->getConexion();
      $sql = "INSERT INTO PERSONA (PER_DNI, PER_nombres, PER_apellidoPaterno, PER_apellidoMaterno, PER_celular, PER_email) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$this->dni, $this->nombres, $this->apellidoPaterno, $this->apellidoMaterno, $this->celular, $this->email]);
      return $conector->lastInsertId();
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
        throw new Exception("Error de conexión con la base de datos.");
      }
    } catch (PDOException $e) {
      throw new Exception("Error al obtener los registros de incidencias: " . $e->getMessage());
    }
  }

  // Metodo para actualizar datos de las personas registradas
  public function actualizarPersona()
  {
    try {
      $conector = $this->getConexion();
      $sql = "UPDATE PERSONA SET PER_dni = ?, PER_nombres = ? , PER_apellidoPaterno = ?, PER_apellidoMaterno = ?, PER_celular = ?, PER_email = ? WHERE PER_codigo = ?";
      $stmt = $conector->prepare($sql);
      $stmt->execute([$this->dni, $this->nombres, $this->apellidoPaterno, $this->apellidoMaterno, $this->celular, $this->email, $this->codigoPersona]);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      throw new Exception("Error al actualizar la persona: " . $e->getMessage());
    }
  }
}
