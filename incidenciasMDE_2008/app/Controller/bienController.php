<?php
require_once 'app/Model/BienModel.php';

class BienController
{
  private $bienModel;

  public function __construct()
  {
    $this->bienModel = new BienModel();
  }

  // Metodo para registrar el tipo de bien
  public function registrarTipoBien()
  {
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
      $codigoIdentificador = $_POST['codigoIdentificador'] ?? null;
      $nombreBien = $_POST['nombreTipoBien'] ?? null;

      if ($nombreBien === null || trim($nombreBien) === '') {
        echo json_encode([
          'success' => false,
          'message' => 'Ingrese nuevo bien.'
        ]);
        exit();
      }

      try {
        // Validar si la persona tiene un usuario
        if ($this->bienModel->validarBienExistente($codigoIdentificador)) {
          echo json_encode([
            'success' => false,
            'message' => 'El c&oacute;digo identificador ingresado ya est&aacute; registrado.',
          ]);
          exit();
        }

        // Insertar tipo de bien
        $insertSuccess = $this->bienModel->insertarTipoBien($codigoIdentificador, $nombreBien);

        if ($insertSuccess) {
          echo json_encode([
            'success' => true,
            'message' => 'Nombre de bien registrado.',
            'BIE_codigo' => $insertSuccess
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'Error al registrar el nombre de bien.',
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'M&eacute;todo no permitido.'
      ]);
    }
  }

  // Metodo para actualizar el tipo de bien
  public function actualizarTipoBien()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $codigoBien = $_POST['codBien'] ?? null;
      $codigoIdentificador = $_POST['codigoIdentificador'] ?? null;
      $nombreBien = $_POST['nombreTipoBien'] ?? null;

      if (empty($nombreBien) || empty($nombreBien)) {
        echo json_encode([
          'success' => false,
          'message' => 'Ingrese nombre del bien.'
        ]);
        exit();
      }

      try {
        // Llamar al metodo para actualizar el tipo de bien
        $updateSuccess = $this->bienModel->editarTipoBien($codigoIdentificador, $nombreBien, $codigoBien);

        if ($updateSuccess) {
          echo json_encode([
            'success' => true,
            'message' => 'Nombre de bien actualizado.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se realiz&oacute; ninguna actualizaci&oacute;n.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      exit();
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'M&eacute;todo no permitido.'
      ]);
    }
  }

  // Controlador para habilitar un bien
  public function habilitarBien()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigoBien = isset($_POST['codBien']) ? $_POST['codBien'] : '';

      try {
        $resultados = $this->bienModel->habilitarBien($codigoBien);
        if ($resultados) {
          echo json_encode([
            'success' => true,
            'message' => 'C&oacute;digo de bien habilitado.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se pudo habilitar el c&oacute;digo de bien.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
      ]);
    }
  }

  // Controlador para deshabilitar un bien
  public function deshabilitarBien()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigoBien = isset($_POST['codBien']) ? $_POST['codBien'] : '';

      try {
        $resultados = $this->bienModel->deshabilitarBien($codigoBien);
        if ($resultados) {
          echo json_encode([
            'success' => true,
            'message' => 'C&oacute;digo de bien deshabilitado.'
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => 'No se pudo habilitar el c&oacute;digo de bien.'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
      ]);
    }
  }

  // Metodo para listar bienes
  public function listarBienes()
  {
    try {
      $resultado = $this->bienModel->listarBienes();

      return $resultado;
    } catch (Exception $e) {
      echo  json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
      ]);
    }
  }

  // Metodo para listar eventos de bienes
  public function listarEventosBienes()
  {
    $resultadoAuditoriaEventosBienes = $this->bienModel->listarEventosBienes();
    return $resultadoAuditoriaEventosBienes;
  }

  // Metodo para consultar todos los eventos de bienes para auditoría
  public function consultarEventosBienes($usuario = NULL, $fechaInicio = null, $fechaFin = null)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      // Obtener los valores de los parámetros GET o asignar null si no existen
      $usuario = isset($_GET['usuarioEventoBienes']) ? (int) $_GET['usuarioEventoBienes'] : null;
      $fechaInicio = isset($_GET['fechaInicioEventosBienes']) ? $_GET['fechaInicioEventosBienes'] : null;
      $fechaFin = isset($_GET['fechaFinEventosBienes']) ? $_GET['fechaFinEventosBienes'] : null;
      // Llamar al método para consultar incidencias por área, código patrimonial y fecha
      $consultaEventosTotales = $this->bienModel->buscarEventosBienes($usuario, $fechaInicio, $fechaFin);
      // Retornar el resultado de la consulta
      return $consultaEventosTotales;
    }
  }
}
