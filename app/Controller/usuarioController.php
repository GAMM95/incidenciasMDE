<?php

require_once 'app/Model/UsuarioModel.php';

class UsuarioController
{
  private $usuarioModel;

  public function __construct()
  {
    $this->usuarioModel = new UsuarioModel($usuario, $password);
  }


  public function registrarUsuario()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $usuario = $_POST['dni'];
      $nombres = $_POST['nombre'];
      $apellidoPaterno = $_POST['apellidoPaterno'];
      $apellidoMaterno = $_POST['apellidoMaterno'];
      $email = $_POST['email'];
      $celular = $_POST['celular'];

      // Llamar al método del modelo para insertar la persona en la base de datos
      $insertSuccessId = $this->usuarioModel->registrarUsuario($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);

      if ($insertSuccessId) {
        header('Location: modulo-persona.php?CodPersona=' . $insertSuccessId);
      } else {
        echo "Error al registrar la persona.";
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }
}
