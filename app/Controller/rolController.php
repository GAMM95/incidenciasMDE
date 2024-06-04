<?php
// Importar el modelo RolModel.php

require_once 'app/Model/RolModel.php';

class RolController
{

  public function registrarRol()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // obtener los datos del formulario
      $nombre = $_POST['NombreRol'];
      $rolModel = new RolModel($nombre);
      // Llamar al metodo del modelo para insertar al rol en la base de datos
      $insertSuccessId = $rolModel->registrarRol($nombre);

      if ($insertSuccessId) {
        header('Location: modulo-rol.php?CodRol=' . $insertSuccessId);
        exit();
      } else {
        echo "Error al registrar rol";
      }
    } else {
      echo "Error: Metodo no permitido";
    }
  }

  public function editarRol()
  {
    $codigo = $_POST['CodRol'] ?? '';
    $nombre = $_POST['NombreRol'] ?? '';
    $rolModel = new RolModel();
    try {
      $rolModel->editarRol($codigo, $nombre);
      header("Location: modulo-rol.php");
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}
