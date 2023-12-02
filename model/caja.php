<?php
require_once  "model/persona.php";


class Caja_Model
{
    private $db;
    private $tipo_caja;
    private $monedas;
    private $billetes;
    private $cambios;
    private $cambio;
    private $DIVISA;
    private $apertura;
    private $caja;
    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->tipo_caja = array();
        $this->monedas = array();
        $this->billetes = array();
        $this->cambios = array();
        $this->cambio = array();
        $this->DIVISA = array();
        $this->apertura = array();
        $this->caja = array();
    }

    public function index()
    {
         $sql = "SELECT
         c.id AS caja_id,
         c.nombre AS NOMBRE_CAJA,
         tc.nombre AS tipo_caja_nombre,
         p.nombre AS trabajador_nombre,
         p.telefono AS trabajador_telefono,
         p.correo AS trabajador_correo,
         c.fecha_registro AS caja_fecha_registro,
         c.estado AS caja_estado
         FROM
         caja c
         JOIN tipo_caja tc ON c.tipo = tc.id
         JOIN empleado e ON c.creada_por = e.id
         JOIN persona p ON e.id_persona = p.id";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->caja[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->caja = array();
        }

        return $this->caja;

    }

    public function tipos_cajas()
    {
        $sql = "SELECT * FROM tipo_caja";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->tipo_caja[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->tipo_caja = array();
        }

        return $this->tipo_caja;
    }
    
    public function select_tipo()
    {
        $sql = "SELECT * FROM tipo_caja WHERE estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->tipo_caja[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->tipo_caja = array();
        }

        return $this->tipo_caja;
    }

    public function divisas()
    {
        $sql = "SELECT * FROM divisa";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->monedas[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->monedas = array();
        }

        return $this->monedas;
    }
    public function select_divisas()
    {
        $sql = "SELECT * FROM divisa WHERE estado=1 and local=2";
        $resultado = $this->db->query($sql);
        $select = array();
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $select[] = $row;
            }
        }
        return $select;
    }
    public function select_monedas()
    {
        $sql = "SELECT * FROM divisa WHERE estado=1";
        $resultado = $this->db->query($sql);
        $select = array();
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $select[] = $row;
            }
        }
        return $select;
    }
    public function billetes()
    {
        $sql = "SELECT m.id,d.simbolo, m.denominacion AS denominaciones, m.estado FROM moneda m INNER JOIN divisa d ON d.id = m.id_divisa";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->billetes[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->billetes = array();
        }

        return $this->billetes;
    }
    public function select_moneda()
    {
        $sql = "SELECT * FROM divisa WHERE local = 2 AND estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->billetes[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->billetes = array();
        }

        return $this->billetes;
    }
    public function mostra_moneda_local()
    {
        $sql_moneda_local = "SELECT nombre, simbolo FROM divisa WHERE local = 1";
        $result_moneda_local = $this->db->query($sql_moneda_local);
        if ($result_moneda_local->num_rows > 0) {
            // Se encontró una moneda local definida
            $row = $result_moneda_local->fetch_assoc();
            return  $row["nombre"] . " (" . $row["simbolo"] . ")";
        }

        return "No se ha definido la moneda";
    }
    public function mostrar_cambio_del_dia()
    {
        // Establece la zona horaria a utilizar
        date_default_timezone_set('America/Managua');

        // Obtén la fecha actual
        $fecha_actual = date('Y-m-d');

        // Realiza la consulta para obtener el tipo de cambio
        $sql = "SELECT t.cambio,m.nombre FROM tipo_cambio t INNER JOIN divisa m ON m.id = t.id_divisa WHERE t.fecha = '$fecha_actual' ";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            // Si se encontró un tipo de cambio para la fecha actual
            while ($row = $result->fetch_assoc()) {
                $this->cambios[] = $row;
            }
        } else {
            // Si no se encontró un tipo de cambio para la fecha actual
            return  $this->cambio = array();
        }
        return $this->cambios;
    }
    public function mostra_cambio()
    {
        date_default_timezone_set('America/Managua');

        // Obtén la fecha actual
        $fecha_actual = date('Y-m-d');
        $timestamp = strtotime($fecha_actual);
        $fecha_formateada = date('Y-m-d', $timestamp);
        $sql = "SELECT t.fecha,t.cambio,m.nombre FROM tipo_cambio t INNER JOIN divisa m ON m.id = t.id_divisa WHERE t.fecha = '$fecha_formateada' ";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->cambio[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->cambio = array();
        }

        return $this->cambio;
    }
    public function ObtenerDatosActualizacionTipo($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT * FROM tipo_caja WHERE id=$id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function InsertarTipoCaja($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "tipo_caja");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO tipo_caja (id,nombre,descripcion,estado) VALUES($id, '$nombre', '$descripcion', '$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarTipoCaja($id,$nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE tipo_caja SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoTipoCaja($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE tipo_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function InsertarDivisa($nombre, $simbolo, $local, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "divisa");
        $nombre = $this->db->real_escape_string($nombre);
        $simbolo = $this->db->real_escape_string($simbolo);
        $local = filter_var($local, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO divisa (id,nombre,simbolo,local,estado) VALUES($id, '$nombre', '$simbolo', '$local', '$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ObtenerDatosActualizacion($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT * FROM divisa WHERE id=$id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function MostrarDivisa()
    {
        $sql = "SELECT * FROM divisa WHERE estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->DIVISA[] = $row;
                }
                return $this->DIVISA;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ActualizarDivisa($id,$nombre, $simbolo, $local, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $simbolo = $this->db->real_escape_string($simbolo);
        $local = filter_var($local, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE divisa SET nombre='$nombre', simbolo='$simbolo', local='$local', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoDivisa($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE divisa SET estado = '$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function InsertarMoneda($id_divisa, $denominacion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($modelos = "moneda");
        $id_divisa = filter_var($id_divisa, FILTER_VALIDATE_INT);
        $denominacion = filter_var($denominacion, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO moneda(id,id_divisa,denominacion,estado) VALUES($id,'$id_divisa','$denominacion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarMoneda($id,$id_divisa , $denominacion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_divisa = filter_var($id_divisa, FILTER_VALIDATE_INT);
        $denominacion = filter_var($denominacion, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE moneda SET id_divisa='$id_divisa', denominacion='$denominacion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function cambiarEstadoDenominacion($id, $estado)
    {
        // Escapar valores para evitar inyección SQL
        $id = $this->db->real_escape_string($id);

        // Actualizar estado en tabla "moneda"
        $sql = "UPDATE moneda 
            SET estado='$estado'
            WHERE id='$id'";
        $this->db->query($sql);

        // Verificar si la actualización fue exitosa
        return $this->db->affected_rows > 0;
    }
    public function InsertarTipoCambio($id_moneda, $fechaMySQL, $cambio)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($modelos = "tipo_cambio");
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $fechaMySQL = $this->db->real_escape_string($fechaMySQL);
        $cambio = $this->db->real_escape_string($cambio);
        $sql = "INSERT INTO tipo_cambio(id,id_divisa,fecha,cambio) VALUES($id,'$id_moneda','$fechaMySQL','$cambio')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarTipoCambio($id,$id_moneda , $cambio)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $cambio = filter_var($cambio, FILTER_VALIDATE_INT);

        $sql = "UPDATE tipo_cambio SET id_moneda='$id_moneda', cambio='$cambio' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoTipoCambio($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE tipo_cambio SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function get_caja($id)
    {
        $id = $this->db->real_escape_string($id);
        $sql = "SELECT * FROM caja WHERE id= $id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function InsertarCaja($tipo, $creada_por, $nombre, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "caja");
        $tipo = filter_var($tipo, FILTER_VALIDATE_INT);
        $creada_por = filter_var($creada_por, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO caja(id,tipo,creada_por,nombre,fecha_registro ,estado) VALUES($id,'$tipo','$creada_por','$nombre',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarCaja($id,$tipo, $creada_por, $nombre, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $tipo = filter_var($tipo, FILTER_VALIDATE_INT);
        $creada_por = filter_var($creada_por, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE `caja` SET `tipo`='$tipo',`creada_por`='$creada_por',`nombre`='$nombre',`estado`='$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoCaja($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function mostrar_apertura()
    {
        $sql = "SELECT  ac.id, tc.nombre AS tipo_caja, c.nombre AS caja, p.nombre AS trabajador,ac.fecha_apertura,
        pa.nombre AS autorizado_por, ac.estado, CONCAT(GROUP_CONCAT(CONCAT(dv.nombre, ': ', FORMAT(subconsulta.total_total, 2)) SEPARATOR ', ') ) AS monto
        FROM apertura_caja ac JOIN caja c ON ac.id_caja = c.id JOIN tipo_caja tc ON c.tipo = tc.id JOIN 
        empleado t ON ac.id_trabajador = t.id
        JOIN empleado ta ON ac.id_autorizado_por = ta.id
        JOIN   persona p ON t.id_persona = p.id JOIN persona pa ON ta.id_persona = pa.id  LEFT JOIN (
        SELECT dv.id AS id_divisa, SUM(m.denominacion * d.monto) AS total_total
        FROM detalle_apertura_caja d
        INNER JOIN 
            moneda m ON d.id_moneda = m.id
        INNER JOIN 
            divisa dv ON m.id_divisa = dv.id
        GROUP BY 
                dv.id, dv.nombre
        ) as subconsulta ON 1=1
        LEFT JOIN divisa dv ON subconsulta.id_divisa = dv.id
        WHERE 
            ac.estado != 1 AND ac.estado !=3
        GROUP BY 
            ac.id, tc.nombre, p.nombre, ac.estado
        ORDER BY 
            ac.id";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->apertura[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->apertura = array();
        }

        return $this->apertura;
    }
    public function solicitud_apertura()
    {
        $aperturas = [];

        // Consulta para obtener aperturas
        $sql = "SELECT 
            ac.id,
            tc.nombre AS tipo_caja,
            c.nombre AS caja,
            c.id AS id_caja,
            p.nombre AS nombre_trabajador,
            ac.estado
        FROM 
            apertura_caja ac
        JOIN 
            caja c ON ac.id_caja = c.id
        JOIN 
            tipo_caja tc ON c.tipo = tc.id
        JOIN 
            empleado t ON ac.id_trabajador = t.id
        JOIN 
            persona p ON t.id_persona = p.id
        WHERE 
            ac.estado = 1
        ORDER BY 
            ac.id";

        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $aperturas[$row['id']] = $row;
            }
        }

        // Consulta para obtener detalles
        foreach ($aperturas as &$apertura) {
            $id_apertura = $apertura['id'];
            $detalles = [];

            $sql = "SELECT 
                dv.nombre AS divisa,
                SUM(m.denominacion * d.monto) AS total_divisa
            FROM 
                detalle_apertura_caja d
            INNER JOIN 
                moneda m ON d.id_moneda = m.id
            INNER JOIN 
                divisa dv ON m.id_divisa = dv.id
            WHERE 
                d.id_apertura_caja = $id_apertura
            GROUP BY 
                dv.nombre";

            $resultado = $this->db->query($sql);
            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $detalles[] = $row;
                }
            }

            $apertura['detalles'] = $detalles;
        }

        return $aperturas;
    }
    public function index2()
    {
        $sql = "SELECT
        c.id AS caja_id,
        c.nombre AS NOMBRE_CAJA,
        tc.nombre AS tipo_caja_nombre,
       
        p.nombre AS trabajador_nombre,
        p.telefono AS trabajador_telefono,
       
        c.fecha_registro AS caja_fecha_registro,
        c.estado AS caja_estado
        FROM
        caja c
        JOIN tipo_caja tc ON c.tipo = tc.id
        JOIN empleado t ON c.creada_por = t.id
        JOIN persona p ON t.id_persona = p.id
       WHERE c.estado=1";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->caja[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->caja = array();
        }

        return $this->caja;
    }
    public function apertura_trabajador($id_trabajador)
    {
        $id_trabajador = $this->db->real_escape_string($id_trabajador);
        $sql = "SELECT * FROM apertura_caja WHERE id_trabajador = $id_trabajador AND estado IN (1, 2) AND (id_autorizado_por IS NULL OR id_autorizado_por <> $id_trabajador)";
        $resultado = $this->db->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
           
            return true; // Devuelve true si hay al menos una apertura
           
           
        } else {
         
            return false; // En caso de error o si no hay aperturas
        }
     
    }
    public function select_divisa()
    {
        $query = "SELECT m.id AS id_moneda, d.nombre,m.denominacion AS nombre_divisa,d.id AS id_divisa FROM moneda m INNER JOIN divisa d ON d.id =m.id_divisa WHERE m.estado = 1 AND d.estado = 1 ORDER BY nombre_divisa";

        $resultado = $this->db->query($query);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un array asociativo para almacenar los datos de las ubicaciones y sus niveles
            $divisas = array();
            while ($row = $resultado->fetch_assoc()) {
                $id_divisa = $row['id_divisa'];
                $divisa_nombre = $row['nombre'];
                $moneda_id = $row['id_moneda'];
                $moneda_nombre = $row['nombre_divisa'];
                if (array_key_exists($id_divisa, $divisas)) {
                    // Si sí, agregar la moneda a la divisa existente
                    $divisas[$id_divisa]['monedas'][] = array(
                        'id' => $moneda_id,
                        'nombre' => $moneda_nombre
                    );
                } else {
                    // Si no, crear una nueva entrada para la divisa con la primera moneda
                    $divisas[$id_divisa] = array(
                        'id' => $id_divisa,
                        'nombre' => $divisa_nombre,
                        'monedas' => array(
                            array(
                                'id' => $moneda_id,
                                'nombre' => $moneda_nombre
                            )
                        )
                    );
                }
            }

            return $divisas;
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            return array();
        }
        // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.

    }
    public function crearAperturaCaja($id_caja, $id_trabajador, $estado)
    {
        // Escapar valores para evitar inyección SQL
        $id_caja = $this->db->real_escape_string($id_caja);
        $id_trabajador = $this->db->real_escape_string($id_trabajador);
        $estado = $this->db->real_escape_string($estado);

        // Insertar en tabla "apertura_caja"
        $sql_apertura_caja = "INSERT INTO apertura_caja (id_caja, id_trabajador, estado) 
                              VALUES ('$id_caja', '$id_trabajador',  '$estado' )";
        $this->db->query($sql_apertura_caja);

        // Obtener el último ID generado en la tabla "apertura_caja"
        $last_id = $this->db->insert_id;

        // Retornar el ID de la apertura de caja creada
        return $last_id;
    }
    public function guardarDetalleAperturaCaja($id_apertura_caja, $id_moneda, $monto, $total)
    {
        // Escapar valores para evitar inyección SQL
        
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "detalle_apertura_caja");
        $id_apertura_caja = $this->db->real_escape_string($id_apertura_caja);
        $id_moneda = $this->db->real_escape_string($id_moneda);
        $monto = $this->db->real_escape_string($monto);
        $total = $this->db->real_escape_string($total);
        // Insertar en tabla "detalle_apertura_caja"
        $sql_detalle_apertura_caja = "INSERT INTO 
        detalle_apertura_caja (id,id_apertura_caja, id_moneda, monto,total) 
                                      VALUES ($id,'$id_apertura_caja', '$id_moneda', '$monto','$total')";
        $this->db->query($sql_detalle_apertura_caja);
    }
    public function cambiar_apertura_caja($id_apertura, $id_autorizado_por, $fecha_apertura, $estado)
    {
        $id_apertura = $this->db->real_escape_string($id_apertura);
        $id_autorizado_por = $this->db->real_escape_string($id_autorizado_por);
        $fecha_apertura = $this->db->real_escape_string($fecha_apertura);
        $estado = $this->db->real_escape_string($estado);
        // Actualizar en tabla "apertura_caja"
        $sql_actualizar_apertura_caja = "UPDATE apertura_caja SET id_autorizado_por = '$id_autorizado_por', 
        fecha_apertura = '$fecha_apertura'  , estado='$estado' WHERE id = '$id_apertura'";
        $this->db->query($sql_actualizar_apertura_caja);
    }



    public function InsertarAperturaCaja($id_caja, $id_trabajador,$id_autorizado_por,$estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "apertura_caja");
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $id_autorizado_por = filter_var($id_autorizado_por, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `apertura_caja`(`id`,`id_caja`,`id_trabajador`,`id_autorizado_por`,`fecha_apertura`,`estado`) VALUES ($id,'$id_caja','$id_trabajador','$id_autorizado_por',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarAperturaCaja($id,$id_caja, $id_trabajador,$id_autorizado_por,$estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $id_autorizado_por = filter_var($id_autorizado_por, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE `apertura_caja` SET `id_caja`='$id_caja',`id_trabajador`='$id_trabajador',`id_autorizado_por`='$id_autorizado_por',`estado`='$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoApertura($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE apertura_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarDetalleAperturaCaja($id_apertura_caja, $id_moneda,$monto,$total)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "detalle_apertura_caja");
        $id_apertura_caja = filter_var($id_apertura_caja, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $monto = filter_var($monto, FILTER_VALIDATE_INT);
        $total = filter_var($total, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO detalle_apertura_caja(id, id_apertura_caja, id_moneda, monto,total) VALUES ($id,'$id_apertura_caja','$id_moneda','$monto','$total')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarDetalleAperturaCaja($id,$id_apertura_caja, $id_moneda,$monto,$total)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_apertura_caja = filter_var($id_apertura_caja, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $monto = filter_var($monto, FILTER_VALIDATE_INT);
        $total = filter_var($total, FILTER_VALIDATE_INT);

        $sql = "UPDATE `detalle_apertura_caja` SET `id_apertura_caja`='$id_apertura_caja',`id_moneda`='$id_moneda',`monto`='$monto',`total`='$total' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoDetalleApertura($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE detalle_apertura_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarMetodoPago($nombre, $descripcion,$estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "metodo_pago");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `metodo_pago`(`id`, `nombre`, `descripcion`, `estado`) VALUES ($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarMetodoPago($id,$nombre, $descripcion,$estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE `metodo_pago` SET `nombre`='$nombre',`descripcion`='$descripcion',`estado`='$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoMetodoPago($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE metodo_pago SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarMovimientoCaja($id_caja, $id_trabajador,$tipo_movimiento, $monto_cordobas, $monto_dolares, $id_metodo_pago)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "movimiento_caja");
        $tipo_movimiento = $this->db->real_escape_string($tipo_movimiento);
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $monto_cordobas = filter_var($monto_cordobas, FILTER_VALIDATE_FLOAT);
        $monto_dolares = filter_var($monto_dolares, FILTER_VALIDATE_FLOAT);
        $id_metodo_pago = filter_var($id_metodo_pago, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `movimiento_caja`(`id`, `id_caja`, `id_trabajador`, `fecha_movimiento`, `tipo_movimiento`, `monto_cordobas`, `monto_dolares`, `id_metodo_pago`) VALUES ($id,'$id_caja','$id_trabajador',NOW(),'$tipo_movimiento','$monto_cordobas','$monto_dolares','$id_metodo_pago')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarMovimientoCaja($id,$id_caja, $id_trabajador,$tipo_movimiento, $monto_cordobas, $monto_dolares, $id_metodo_pago)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $tipo_movimiento = $this->db->real_escape_string($tipo_movimiento);
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $monto_cordobas = filter_var($monto_cordobas, FILTER_VALIDATE_FLOAT);
        $monto_dolares = filter_var($monto_dolares, FILTER_VALIDATE_FLOAT);
        $id_metodo_pago = filter_var($id_metodo_pago, FILTER_VALIDATE_INT);

        $sql = "UPDATE
        `movimiento_caja`
    SET
        `id_caja` = '$id_caja',
        `id_trabajador` = '$id_trabajador',
        `tipo_movimiento` = '$tipo_movimiento',
        `monto_cordobas` = '$monto_cordobas',
        `monto_dolares` = '$monto_dolares',
        `id_metodo_pago` = '$id_metodo_pago'
    WHERE 
         id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoMovimientoCaja($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE movimiento_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarArqueoCaja($id_caja, $id_trabajador,$monto_inicial, $monto_final, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "arqueo_caja");
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $monto_inicial = filter_var($monto_inicial, FILTER_VALIDATE_FLOAT);
        $monto_final = filter_var($monto_final, FILTER_VALIDATE_FLOAT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO `arqueo_caja`(`id`, `id_caja`, `id_trabajador`, `fecha_arqueo`, `monto_inicial`, `monto_final`, `estado`) VALUES ($id,'$id_caja','$id_trabajador',NOW(),'$monto_inicial','$monto_final','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarArqueoCaja($id,$id_caja, $id_trabajador,$monto_inicial, $monto_final, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $monto_inicial = filter_var($monto_inicial, FILTER_VALIDATE_FLOAT);
        $monto_final = filter_var($monto_final, FILTER_VALIDATE_FLOAT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "UPDATE
        `arqueo_caja`
    SET
        `id_caja` = '$id_caja',
        `id_trabajador` = '$id_trabajador',
        `monto_inicial` = '$monto_inicial',
        `monto_final` = '$monto_final',
        `estado` = '$estado'
        
        WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoArqueoCaja($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE arqueo_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarDetalleArqueo($id_apertura, $id_moneda,$cantidad_billete, $monto_billete)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "detalle_arqueo");
        $id_apertura = filter_var($id_apertura, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $cantidad_billete = filter_var($cantidad_billete, FILTER_VALIDATE_INT);
        $monto_billete = filter_var($monto_billete, FILTER_VALIDATE_FLOAT);

        $sql = "INSERT INTO `detalle_arqueo`(`id`, `id_apertura`, `id_moneda`, `cantidad_billete`, `monton_billete`) VALUES ($id,'$id_apertura','$id_moneda','$cantidad_billete','$monto_billete')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarDetalleArqueo($id,$id_apertura, $id_moneda,$cantidad_billete, $monto_billete)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_apertura = filter_var($id_apertura, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $cantidad_billete = filter_var($cantidad_billete, FILTER_VALIDATE_INT);
        $monto_billete = filter_var($monto_billete, FILTER_VALIDATE_FLOAT);

        $sql = "UPDATE `detalle_arqueo` SET`id_apertura`='$id_apertura',`id_moneda`='$id_moneda',`cantidad_billete`='$cantidad_billete',`monton_billete`='$monto_billete' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoDetalleArqueo($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE detalle_arqueo SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarCierreCaja($id_cierre_caja, $id_trabajador,$id_autorizado, $motivo,$estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "cierre_caja");
        $id_cierre_caja = filter_var($id_cierre_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $id_autorizado = filter_var($id_autorizado, FILTER_VALIDATE_INT);
        $motivo = $this->db->real_escape_string($motivo);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO `cierre_caja`(`id`, `id_cierre_caja`, `id_trabajador`, `id_autorizado`, `motivo`, `fecha_cierre`, `estado`) VALUES ($id,'$id_cierre_caja','$id_trabajador','$id_autorizado','$motivo',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarCierreCaja($id,$id_cierre_caja, $id_trabajador,$id_autorizado, $motivo,$estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_cierre_caja = filter_var($id_cierre_caja, FILTER_VALIDATE_INT);
        $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
        $id_autorizado = filter_var($id_autorizado, FILTER_VALIDATE_INT);
        $motivo = $this->db->real_escape_string($motivo);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE `cierre_caja` SET `id_cierre_caja`='$id_cierre_caja',`id_trabajador`='$id_trabajador',`id_autorizado`='$id_autorizado',`motivo`='$motivo',`estado`='$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoCierreCaja($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE cierre_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

    public function InsertarDetalleCierre($id_caja, $id_moneda,$monto_cierre)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tabla = "detalle_cierre_caja");
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $monto_cierre = filter_var($monto_cierre, FILTER_VALIDATE_FLOAT);

        $sql = "INSERT INTO `detalle_cierre_caja`(`id`, `id_caja`, `id_moneda`, `monto_cierre`) VALUES ($id,'$id_caja','$id_moneda','$monto_cierre')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: ".$this->db->error;
        }
    }
    public function ActualizarDetalleCierre($id,$id_caja, $id_moneda,$monto_cierre)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_caja = filter_var($id_caja, FILTER_VALIDATE_INT);
        $id_moneda = filter_var($id_moneda, FILTER_VALIDATE_INT);
        $monto_cierre = filter_var($monto_cierre, FILTER_VALIDATE_FLOAT);

        $sql = "UPDATE `detalle_cierre_caja` SET `id_caja`='$id_caja',`id_moneda`='$id_moneda',`monto_cierre`='$monto_cierre' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoDetalleCierre($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE detalle_cierre_caja SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }

}


?>