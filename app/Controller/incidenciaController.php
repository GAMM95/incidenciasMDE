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
      $fecha = $_POST['fecha'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $asunto =  $_POST['asunto'] ?? null;
      $descripcion = $_POST['descripcion'] ?? null;
      $documento = $_POST['documento'] ?? null;
      $codigoPatrimonial = $_POST['codigo_patrimonial'] ?? null;
      $categoria = $_POST['categoria'] ?? null;
      $area = $_POST['area'] ?? null;
      $usuario = $_POST['usuario'] ?? null;

      // Verificar que la fecha no es nula
      if ($fecha === null || $fecha === '') {
        echo "Error: La fecha es un campo obligatorio.";
        return;
      }

      if ($hora === null || $hora === '') {
        echo "Error: La hora es un campo obligatorio.";
        return;
      }

      if ($asunto === null || trim($asunto) === '') {
        echo "Error: El asunto de la incidencia no puede estar vacío";
        return;
      }

      if ($documento === null || trim($documento) === '') {
        echo "Error: El documento de la incidencia no puede estar vacío";
        return;
      }

      if ($categoria === null || $categoria === '') {
        echo "Error: La categoria de la incidencia no puede estar vacío";
        return;
      }

      if ($area === null || $area === '') {
        echo "Error: El area de la incidencia no puede estar vacío";
        return;
      }

      if ($usuario === null || $usuario === '') {
        echo "Error: El usuario de la incidencia no puede estar vacío";
        return;
      }


      // Llamar al método del modelo para insertar la incidencia en la base de datos
      $insertSuccessId = $this->incidenciaModel->insertarIncidencia(
        $fecha,
        $hora,
        $asunto,
        $descripcion,
        $documento,
        $codigoPatrimonial,
        3,
        $categoria,
        $area,
        $usuario
      );

      if ($insertSuccessId) {
        header('Location: registro-incidencia-admin.php?INC_numero=' . $insertSuccessId);
      } else {
        echo "Error al registrar la incidencia.";
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }

  // TODO: Metodo para otbener la lista de incidencias segun el area a la pertenece el usuario
  public function listarIncidenciasUsuarioArea()
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $area = $_POST['area'] ?? null;
    }
  }
}
