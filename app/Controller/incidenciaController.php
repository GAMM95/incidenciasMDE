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
      $fecha = $_POST['fecha_incidencia'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $asunto =  $_POST['asunto'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $codigoPatrimonial = $_POST['codigo_patrimonial'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $area = $_POST['area'] ?? null;
      $usuario = $_POST['usuario'] ?? null;

      // Verificar campos obligatorios
      if ($fecha === null || $fecha === '') {
        echo "Error: La fecha es un campo obligatorio.";
        return;
      }

      if ($hora === null || $hora === '') {
        echo "Error: La hora es un campo obligatorio.";
        return;
      }

      if ($usuario === null || $usuario === '') {
        echo "Error: El usuario de la incidencia no puede estar vacío";
        return;
      }

      if ($categoria === null || $categoria === '') {
        echo "Error: La categoría no puede estar vacía";
        return;
      }

      if ($area === null || $area === '') {
        echo "Error: El área no puede estar vacía";
        return;
      }

      // Llamar al método del modelo para insertar la incidencia en la base de datos
      $insertSuccessId = $this->incidenciaModel->insertarIncidenciaAdministrador(
        $fecha,
        $hora,
        $asunto,
        $descripcion,
        $documento,
        $codigoPatrimonial,
        $categoria,
        $area,
        $usuario
      );

      if ($insertSuccessId === -1) {
        echo 'Error al registrar la incidencia';
      } else {
        echo "Incidencia registrada correctamente con ID: " . $insertSuccessId;
      }
    }
  }


  // TODO: Metodo para otbener la lista de incidencias segun el area a la pertenece el usuario
  public function listarIncidenciasUsuarioArea()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $area = $_POST['area'] ?? null;
    }
  }
}
