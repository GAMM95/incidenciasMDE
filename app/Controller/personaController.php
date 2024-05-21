<?php
// Importar el modelo MantPersonaModel.php
require_once 'app/Model/PersonaModel.php';

class PersonaController
{
  private $personaModel;

  public function __construct($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular)
  {
    // Aquí asignamos los valores a las propiedades del modelo PersonaModel
    $this->personaModel = new PersonaModel($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);
  }

  public function registrarPersona()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $dni = $_POST['dni'];
      $nombres = $_POST['nombre'];
      $apellidoPaterno = $_POST['apellidoPaterno'];
      $apellidoMaterno = $_POST['apellidoMaterno'];
      $email = $_POST['email'];
      $celular = $_POST['celular'];

      // Llamar al método del modelo para insertar la persona en la base de datos
      $insertSuccessId = $this->personaModel->registrarPersona($dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);

      if ($insertSuccessId) {
        header('Location: mantenimiento-persona.php?CodPersona=' . $insertSuccessId);
      } else {
        echo "Error al registrar la persona.";
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }

  public function actualizarPersona()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $codPersona = $_POST['codPersona'];
      $dni = $_POST['dni'];
      $nombres = $_POST['nombre'];
      $apellidoPaterno = $_POST['apellidoPaterno'];
      $apellidoMaterno = $_POST['apellidoMaterno'];
      $email = $_POST['email'];
      $celular = $_POST['celular'];

      // Llamar al método del modelo para actualizar la persona en la base de datos
      $updateSuccess = $this->personaModel->actualizarPersona($codPersona, $dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);

      if ($updateSuccess) {
        header('Location: mantenimiento-persona.php?CodPersona=' . $codPersona);
      } else {
        echo "Error al actualizar la persona.";
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }
}
