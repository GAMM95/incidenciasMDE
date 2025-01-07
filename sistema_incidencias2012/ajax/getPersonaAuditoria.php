<?php
require_once '../config/conexion.php';

class UsuarioEvento extends Conexion
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getUsuarioEvento()
  {
    $conector = parent::getConexion();
    $query = "SELECT u.USU_codigo, p.PER_codigo, 
            (PER_nombres + ' ' + PER_apellidoPaterno) AS persona 
            FROM PERSONA p
            INNER JOIN USUARIO u ON u.PER_codigo = p.PER_codigo
            ORDER BY persona ASC";
    $stmt = $conector->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
  }
}

$usuarioEvento = new UsuarioEvento();
$usuario = $usuarioEvento->getUsuarioEvento();

header('Content-Type: application/json');
echo json_encode($usuario);
exit();