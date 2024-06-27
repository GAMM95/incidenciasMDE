<?php
// Importamos las credenciales y la clase de conexión
require_once 'config/conexion.php';

class RecepcionModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function insertarRecepcion($CodUsuario, $CodImpacto, $CodPrioridad, $Hora, $FechaRecepcion, $NumIncidencia, $CodEstado)
    {
        $conn = $this->conexion->getConexion();

        if ($conn != null) {
            // Preparar la consulta SQL para la inserción sin incluir el campo id
            $sql = "INSERT INTO RECEPCION (CodUsuario, CodImpacto, CodPrioridad, Hora, FechaRecepcion, NumIncidencia,CodEstado)
                VALUES (?, ?, ?, ?, ?, ?,?)";

            // Preparar la sentencia
            $stmt = $conn->prepare($sql);


            $success = $stmt->execute(
                [
                    $CodUsuario,
                    $CodImpacto,
                    $CodPrioridad,
                    $Hora,
                    $FechaRecepcion,
                    $NumIncidencia,
                    1
                ]
            );


            if ($success) {
                echo "Error al insertar la recepcion.";
                return $success;
            } else {
                return false;
            }
        } else {
            echo "Error de conexión cierreController la base de datos.";
            return false;
        }
    }

    public function recepcionarIncidencia($NumIncidencia)
    {
        $conn = $this->conexion->getConexion();

        if ($conn != null) {
            // Preparar la consulta SQL para la inserción sin incluir el campo id
            $sql = "UPDATE Incidencia SET CodEstado = 2 WHERE NumIncidencia = ?";

            // Preparar la sentencia
            $stmt = $conn->prepare($sql);

            // Ejecutar la inserción sin proporcionar el valor para el campo id
            $success = $stmt->execute(
                [
                    $NumIncidencia
                ]
            );

            if ($success) {
                echo "Error al actualizar la incidencia.";
                return $success;
            } else {
                return false;
            }
        } else {
            echo "Error de conexión cierreController la base de datos.";
            return false;
        }
    }

    public function obtenerRecepcionesRegistradas()
    {
        try {
            $conn = $this->conexion->getConexion();

            if ($conn != null) {
                $sql = "SELECT REC_numero, r.INC_numero, i.INC_codigoPatrimonial, i.EST_codigo, 
                P.PRI_nombre, r.REC_fecha, Imp.IMP_codigo
          FROM Recepcion r
          INNER JOIN INCIDENCIA i ON r.INC_numero = i.INC_numero
          INNER JOIN PRIORIDAD p ON r.PRI_codigo = P.PRI_codigo
          INNER JOIN IMPACTO Imp ON r.IMP_codigo = Imp.IMP_codigo 
          WHERE r.EST_codigo = 4
          ORDER BY R.REC_numero";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                throw new Exception("Error de conexión a la base de datos.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
        }
    }

    public function listarRecepcionesRegistradas()
    //esta funcion es para concultar recepcion
    {
        try {
            $conn = $this->conexion->getConexion();

            if ($conn != null) {
                $sql = "SELECT R.REC_codigo, R.INC_codigo, I.INC_codigoPatrimonial AS codigo_patrimonial, I.INC_estado, 
                P.PRI_nombre AS prioridad, R.REC_fecha, INC_asunto, a.ARE_nombre, c.CAT_nombre
          FROM Recepcion R
          INNER JOIN Incidencia I ON R.INC_codigo = I.INC_codigo
          INNER JOIN Prioridad P ON R.PRI_codigo = P.PRI_codigo
          INNER JOIN Impacto Imp ON R.IMP_codigo = Imp.IMP_codigo 
		  inner join CATEGORIA c on i.CAT_codigo = c.CAT_codigo
		  inner join area a on i.INC_codigo = a.ARE_codigo
          
          ORDER BY R.REC_codigo";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                throw new Exception("Error de conexión a la base de datos.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
        }
    }

    public function BuscarRecepcionesRegistradas()
    {
        try {
            $conn = $this->conexion->getConexion();

            if ($conn != null) {
                $sql = "SELECT R.REC_codigo, R.INC_codigo, I.INC_codigoPatrimonial AS codigo_patrimonial, I.INC_estado, 
                P.PRI_nombre AS prioridad, R.REC_fecha, Imp.IMP_nombre AS impacto, C.CAT_nombre
          FROM Recepcion R
          INNER JOIN Incidencia I ON R.INC_codigo = I.INC_codigo
          INNER JOIN Prioridad P ON R.PRI_codigo = P.PRI_codigo
          INNER JOIN Impacto Imp ON R.IMP_codigo = Imp.IMP_codigo 
		  inner join CATEGORIA c on i.CAT_codigo = c.CAT_codigo

          WHERE I.INC_estado != 3 and R.REC_codigo like '1%'
          ORDER BY R.REC_codigo";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                throw new Exception("Error de conexión a la base de datos.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener las recepciones: " . $e->getMessage());
        }
    }
}
