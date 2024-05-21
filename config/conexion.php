<?php
// Importamos las credenciales
require 'settings.php';

class Conexion
{
  private $conector = null;

  /**
   * Este metodo permite obtener una conexión cierreController la base de datos de SQL SERVER, utilizando los valores de configuración.
   * @return PDO|null Retorna el objeto de conexión PDO si la conexión es exitosa, o null en caso contrario.
   */
  public function getConexion()
  {
    // Crea una nueva instancia de PDO.
    $this->conector = new PDO("sqlsrv:server=" . SERVIDOR . ";database=" . DATABASE, USUARIO, PASSWORD);

    // Devuelve el objeto de conexión PDO.
    return $this->conector;
  }
}

// Crea una instancia de la clase Conexion
$con = new Conexion();

// Intenta obtener una conexión cierreController la base de datos y muestra un mensaje en consecuencia
if ($con->getConexion() != null) {
  // echo "Conexión exitosa";

} else {
  echo "Error al conectarse cierreController la base de datos";
}
