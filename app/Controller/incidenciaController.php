<?php
// Importar el modelo IncidenciaModel.php
require 'app/Model/IncidenciaModel.php';


class IncidenciaController
{
  private $incidenciaModel;
  public function __construct($incidenciaModel=null)
  {
    $this->incidenciaModel = $incidenciaModel;
  }

  public function registrarIncidencia()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario
      $categoria = $_POST['categoria'];
      $area = $_POST['area'];
      $fecha = $_POST['fecha'];
      $hora = $_POST['hora'];
      $codigo_patrimonial = $_POST['codigo_patrimonial'];
      $asunto = $_POST['asunto'];
      $numero_documento = $_POST['numero_documento'];
      $documento = $_POST['documento'];
      $descripcion = $_POST['descripcion'];

      // Llamar al método del modelo para insertar la incidencia en la base de datos
      $insertSuccessId = $this->incidenciaModel->insertarIncidencia($fecha, $asunto, $codigo_patrimonial, $documento, 1, $numero_documento, $descripcion, $categoria, $area, 1, $hora);

      if ($insertSuccessId) {

        header('Location: registro-incidencia.php?NumIncidencia=' . $insertSuccessId);
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
