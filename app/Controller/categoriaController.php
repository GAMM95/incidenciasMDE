<?php
require_once 'app/Model/CategoriaModel.php';

class CategoriaController
{
  private $categoriaModel;

  public function __construct()
  {
    $this->categoriaModel = new CategoriaModel();
  }

  public function registrarCategoria()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $nombre = $_POST['NombreCategoria']; // Asegúrate de que el nombre del campo coincide con el de la vista

      // Crear una nueva instancia de CategoriaModel con el nombre proporcionado
      $categoriaModel = new CategoriaModel($nombre);

      // Llamar al método del modelo para insertar la categoría en la base de datos
      $insertSuccessId = $categoriaModel->registrarCategoria();

      if ($insertSuccessId) {
        header('Location: modulo-categoria.php?CodCategoria=' . $insertSuccessId);
        exit(); // Asegúrate de salir después de redirigir
      } else {
        echo "Error al registrar categoría";
      }
    } else {
      echo "Error: Método no permitido";
    }
  }
}
