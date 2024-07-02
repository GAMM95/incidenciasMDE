<?php
// require_once 'app/Model/IncidenciaModel.php';

class InicioController extends Conexion
{
  private $incidenciasModel;
  private $recepcionModel;
  private $cierreModel;

  public function __construct()
  {
    $this->incidenciasModel = new IncidenciaModel();
    $this->recepcionModel = new RecepcionModel();;
    $this->cierreModel = new CierreModel();
  }

  // TODO: MOSTRAR CANTIDADES PARA EL INICIO DEL ADMINISTRADOR
  public function mostrarCantidadesAdministrador()
  {
    try {
      $cantidadIncidenciasMesActual = $this->incidenciasModel->contarIncidenciasUltimoMesAdministrador();
      $cantidadRecepcionesMesActual = $this->recepcionModel->contarRecepcionesUltimoMesAdministrador();
      $cantidadCierresMesActual = $this->cierreModel->contarCierresUltimoMesAdministrador();

      return [
        'incidencias_mes_actual' => $cantidadIncidenciasMesActual,
        'recepciones_mes_actual' => $cantidadRecepcionesMesActual,
        'cierres_mes_actual' => $cantidadCierresMesActual
      ];
    } catch (Exception $e) {
      throw new Exception('Error al obtener las cantidades: ' . $e->getMessage());
    }
  }

  // TODO: MOSTRAR CANTIDADES PARA EL INCIO DEL USUARIO
  public function mostrarCantidadesUsuario()
  {
    try {
      $cantidadIncidenciasMesActual = $this->incidenciasModel->contarIncidenciasUltimoMesAdministrador();

      return [
        'incidencias_mes_actual' => $cantidadIncidenciasMesActual,
      ];
    } catch (Exception $e) {
      throw new Exception('Error al obtener las cantidades: ' . $e->getMessage());
    }
  }
}
