<?php
// Importar el modelo RolModel.php

require_once 'app/Model/RolModel.php';

class RolController
{
  private $rolModel;

  public function __construct($nombre)
  {
    $this->rolModel = new RolModel($nombre);
  }

  public function registrarRol()
  {
    if ($_SERVER["REQUST_METHOD"] == "POST") {
      // obtener los datos del formulario
      $nombre = $_POST['nombre'];

      // Llamar al metodo del modelo para insertar al rol en la base de datos
      $insertSuccessId = $this->rolModel->registrarRol($nombre);

      if ($insertSuccessId) {
        header('Location: modulo-rol.php?CodRol=' . $insertSuccessId);
      } else {
        echo "Error al registrar rol";
      }
    } else {
      echo "Error: Metodo no permitido";
    }
  }

  public function actualizarRol()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $codRol = $_POST['codRol'];
      $nombre = $_POST['nombre'];

      // Llamar al metodo para actualizar el rol de la base de datos
      $updateSuccess = $this->rolModel->editarRol($codRol, $nombre);

      if ($updateSuccess) {
        header('Location: detalle');
      } else {
        echo "Error al actualizar el rol";
      }
    } else {
      echo "Error: Metodo no permitido";
    }
  }
}
