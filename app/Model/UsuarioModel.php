<?php
require_once 'config/conexion.php';

class UsuarioModel
{
  private $conector;
  protected $username;
  protected $password;

  public function __construct($username, $password)
  {
    $this->conector = (new Conexion())->getConexion();
    $this->username = $username;
    $this->password = $password;
  }

  public function iniciarSesion()
  {
    $query = "EXEC SP_Usuario_login :username, :password";
    $stmt = $this->conector->prepare($query);
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $this->password);
    $stmt->execute();

    $resultado = $stmt->fetch();

    if ($resultado) {
      session_start();
      $_SESSION['nombreDePersona'] = $resultado['PER_nombres'];
      $_SESSION['area'] = $resultado['ARE_nombre'];
      $informacionUsuario = $this->obtenerInformacionUsuario($this->username, $this->password);
      $codigo = $informacionUsuario['codigo'];
      $usuario = $informacionUsuario['usuario'];
      $_SESSION['codigoUsuario'] = $codigo;
      $_SESSION['usuario'] = $usuario;
      $_SESSION['rol'] = $this->obtenerRol($this->username); // Guardar rol en la sesión

      // Log de inicio de sesión
      $logData = "------- START LOGIN LOGS ---------" . PHP_EOL;
      $logData .= "Nombre de Persona: " . $_SESSION['nombreDePersona'] . ", Área: " . $_SESSION['area'] . ", Código de Usuario: " . $codigo . ", Usuario: " . $usuario . PHP_EOL;
      file_put_contents('logs/log.txt', $logData, FILE_APPEND);

      return true;
    }
    return false;
  }

  private function obtenerInformacionUsuario($username, $password)
  {
    $consulta = "SELECT USU_codigo as codigo, USU_nombre as usuario FROM USUARIO u WHERE USU_nombre = :username AND USU_password = :password";
    $stmt = $this->conector->prepare($consulta);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $fila = $stmt->fetch();

    if ($fila) {
      return $fila;
    } else {
      return null;
    }
  }

  public function obtenerRol($username)
  {
    $consulta = "SELECT ROL_nombre as rol
        FROM USUARIO u
        INNER JOIN ROL r ON r.ROL_codigo = u.ROL_codigo 
        WHERE USU_nombre = :username";
    $stmt = $this->conector->prepare($consulta);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $fila = $stmt->fetch();

    if ($fila) {
      return $fila['rol'];
    } else {
      return null;
    }
  }

  public function redireccionSegunRol($username)
  {
    $rol = $this->obtenerRol($username);
    if ($rol === 'Administrador') {
      header('Location: pagina-inicio.php');
    } elseif ($rol === 'Trabajador') {
      header('Location: pagina-inicio.php');
    } else {
      // No se redirige
    }
  }

  public function registrarUsuario()
  {
    // Implementar lógica de registro de usuario
  }
}
