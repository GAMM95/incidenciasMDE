<?php
// Importar el modelo IncidenciaModel.php
require 'app/Model/IncidenciaModel.php';

class IncidenciaController
{
  private $incidenciaModel;
  public function __construct()
  {
    $this->incidenciaModel = new IncidenciaModel();
  }

  // TODO: Metodo de controlador para registrar incidencias
  public function registrarIncidencia()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $fecha = $_POST['fecha'];
      $hora = $_POST['hora'];
      $asunto =  $_POST['asunto'];
      $descripcion = $_POST['descripcion'];
      $documento = $_POST['documento'];
      $codigoPatrimonial = $_POST['codigo_patrimonial'];
      $categoria = $_POST['categoria'];
      $area = $_POST['area'];
      $usuario = $_POST['usuario'];

      // Llamar al método del modelo para insertar la incidencia en la base de datos
      $insertSuccessId = $this->incidenciaModel->insertarIncidencia(
        $fecha, $hora, $asunto, $descripcion, $documento, $codigoPatrimonial, 3, $categoria, $area, $usuario);

      if ($insertSuccessId) {

        header('Location: registro-incidencia-admin.php?INC_numero=' . $insertSuccessId);
        // Mostrar los datos de las incidencias
      } else {
        // Mostrar un mensaje de error
        echo "Error al registrar la incidencia.";
      }
    } else {
      // Manejar el caso en el que no se recibe un POST (puede ser una redirección o una respuesta de error)
      echo "Error: Método no permitido.";
    }
  }
}
