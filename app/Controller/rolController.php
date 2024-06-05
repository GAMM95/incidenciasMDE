<?php

require_once 'app/Model/RolModel.php';

class RolController
{

  private $rolModel;

  public function __construct()
  {
    $this->rolModel = new RolModel();
  }

  public function registrarRol()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = $_POST['NombreRol'] ?? null;

      if ($nombre === null || trim($nombre) === '') {
        echo "Error: El nombre del rol no puede estar vacío.";
        return;
      }

      try {
        $rolModel = new RolModel(null, $nombre);
        $insertSuccessId = $rolModel->registrarRol();
        if ($insertSuccessId) {
          header('Location: modulo-rol.php?CodRol=' . $insertSuccessId);
          exit();
        } else {
          echo "Error al registrar rol";
        }
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
    } else {
      echo "Error: Método no permitido";
    }
  }

  public function editarRol()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigo = $_POST['CodRol'] ?? null;
      $nombre = $_POST['NombreRol'] ?? null;

      if ($codigo === null || trim($codigo) === '') {
        echo "Error: El codigo del rol no puede estar vacío";
        return;
      }

      if ($nombre === null || trim($nombre) === '') {
        echo "Error: El nombre del rol no puede estar vacío.";
        return;
      }

      try {
        $rolModel = new RolModel($codigo, $nombre);
        $rolModel->editarRol();
        header("Location: modulo-rol.php?CodRol=" . $codigo);
        exit();
      } catch (Exception $e) {
        echo  "Error: " . $e->getMessage();
      }
    } else {
      echo "Error: Método no permitido";
    }
  }

  public function listarCategorias()
  {
    try {
      $roles = $this->rolModel->listarRol();
      // Aquí deberías retornar o incluir una vista que muestre la tabla de categorías
      // Dependiendo de cómo manejes las vistas, podrías pasar $categorias a la vista
      // Ejemplo:
      // include 'views/categoriaTabla.php';
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}
