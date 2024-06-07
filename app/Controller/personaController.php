<?php
require_once 'app/Model/PersonaModel.php';

class PersonaController
{
  private $personaModel;

  public function __construct()
  {
    $this->personaModel = new PersonaModel();
  }

  public function registrarPersona()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $dni = $_POST['dni'] ?? null;
      $nombres = $_POST['nombre'] ?? null;
      $apellidoPaterno = $_POST['apellidoPaterno'] ?? null;
      $apellidoMaterno = $_POST['apellidoMaterno'] ?? null;
      $email = $_POST['email'] ?? null;
      $celular = $_POST['celular'] ?? null;

      if ($dni === null || trim($dni) === '') {
        echo "Error: El dni de la persona no puede estar vacío";
        return;
      }

      if ($nombres === null) {
        echo "Error: El nombre de la persona no puede estar vacío";
        return;
      }

      if ($apellidoPaterno === null || trim($apellidoPaterno) === '') {
        echo "Error: El apellido paterno de la persona no puede estar vacío";
        return;
      }

      if ($apellidoMaterno === null || trim($apellidoMaterno) === '') {
        echo "Error: El apellido materno de la persona no puede estar vacío";
        return;
      }

      if ($email === null || trim($email) === '') {
        echo "Error: El email de la persona no puede estar vacío";
        return;
      }

      if ($celular === null || trim($celular) === '') {
        echo "Error: El número de celular de la persona no puede estar vacío";
        return;
      }

      try {
        $personaModel = new PersonaModel(null, $dni, $nombres, $apellidoPaterno, $apellidoMaterno, $email, $celular);
        $insertSuccessId = $personaModel->registrarPersona();
        if ($insertSuccessId) {
          header('Location: modulo-persona.php?CodPersona=' . $insertSuccessId);
          exit();
        } else {
          echo "Error al registrar persona";
        }
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
    } else {
      echo "Error: Método no permitido";
    }
  }


  public function actualizarPersona()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $codPersona = $_POST['codPersona'] ?? null;
      $dni = $_POST['dni'] ?? null;
      $nombres = $_POST['nombre'] ?? null;
      $apellidoPaterno = $_POST['apellidoPaterno'] ?? null;
      $apellidoMaterno = $_POST['apellidoMaterno'] ?? null;
      $email = $_POST['email'] ?? null;
      $celular = $_POST['celular'] ?? null;

      if ($codPersona === null || trim($codPersona) === '') {
        echo "Error: El codigo de la persona no puede estar vacío";
        return;
      }
      if ($dni === null || trim($dni) === '') {
        echo "Error: El dni de la persona no puede estar vacío";
        return;
      }

      if ($nombres === null || trim($nombres) === '') {
        echo "Error: El nombre de la persona no puede estar vacío";
        return;
      }

      if ($apellidoPaterno === null || trim($apellidoPaterno) === '') {
        echo "Error: El apellido paterno de la persona no puede estar vacío";
        return;
      }

      if ($apellidoMaterno === null || trim($apellidoMaterno) === '') {
        echo "Error: El apellido materno de la persona no puede estar vacío";
        return;
      }

      if ($email === null || trim($email) === '') {
        echo "Error: El email de la persona no puede estar vacío";
        return;
      }

      if ($celular === null || trim($celular) === '') {
        echo "Error: El número de celular de la persona no puede estar vacío";
        return;
      }
      // Llamar al método del modelo para actualizar la persona en la base de datos
      try {
        $personaModel = new PersonaModel($codPersona, $dni, $nombres, $apellidoPaterno, $apellidoMaterno, $celular, $email);
        $personaModel->actualizarPersona();
        echo "Persona actualizada correctamente";
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }
}
