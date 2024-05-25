<?php

require_once 'app/Model/AreaModel.php';

class AreaController
{
  private $areaModel;

  public function __construct($nombre)
  {
    $this->areaModel = new AreaModel($nombre);
  }

  public function registrarArea()
  {
    if ($_SERVER["REQUST_METHOD"] == "POST") {
      // obtener los datos del formulario
      $nombre = $_POST['nombre'];

      // Llamar al metodo del modelo para insertar la categoria en la base de datos
      $insertSuccessId = $this->areaModel->registrarArea($nombre);

      if ($insertSuccessId) {
        header('Location: modulo-area.php?CodArea=' . $insertSuccessId);
      } else {
        echo "Error al registrar categoria";
      }
    } else {
      echo "Error: Metodo no permitido";
    }
  }
}
