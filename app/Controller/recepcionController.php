<?php
require 'app/Model/RecepcionModel.php';
// require 'app/models/IncidenciaModel.php';

class RecepcionController
{
  private $recepcionModel;
  private $incidenciaModel;

  public function __construct()
  {
    $this->recepcionModel = new RecepcionModel();
    // $this->incidenciaModel = new IncidenciaModel();
  }

  public function registrarRecepcion()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los datos del formulario

      $fecha = $_POST['fecha'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $incidencia = $_POST['incidencia'] ?? null;
      $prioridad = $_POST['prioridad'] ?? null;
      $impacto  = $_POST['impacto'] ?? null;
      $usuario = $_POST['usuario'] ?? null;

      // Verificar que la fecha no es nula
      if ($fecha === null || $fecha === '') {
        echo "Error: La fecha es un campo obligatorio.";
        return;
      }

      // Llamar al método del modelo para insertar la incidencia en la base de datos
      $insertSuccessId = $this->recepcionModel->insertarRecepcion(
        $fecha,
        $hora,
        $incidencia,
        $prioridad,
        $impacto,
        $usuario,
      );

      if ($insertSuccessId) {
        header('Location: registro-recepcion-admin.php?REC_numero=' . $insertSuccessId);
      } else {
        echo "Error al registrar la recepcion.";
      }
    } else {
      echo "Error: Método no permitido.";
    }
  }
}
