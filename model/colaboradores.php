<?php
require_once "model/persona.php";
class Colaboradores_Model
{
    private $db;
    private $cargos;
    private $empleado;
    private $salarios;
    private $contratos;
    private $TipoContratos;
    private $Asignacion;

    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->cargos = array();
        $this->empleado = array();
        $this->salarios = array();
        $this->TipoContratos = array();
        $this->Asignacion = array();
        $this->contratos = array();
    }

    /***
     * Gestion de cargos
     */
    public function GenerarCodigo($id, $nombre)
    {
        $fecha_registro = date('Ymd');
        $id_formateado = str_pad($id, 4, '0', STR_PAD_LEFT);
        $nombre_limpio = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $nombre));
        // Concatenar los elementos para formar el código
        $codigo = $fecha_registro . $id_formateado . $nombre_limpio;
        return $codigo;
    }
    public function MostrarCargos()
    {
        $sql = "SELECT * FROM  puestos";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->cargos[] = $row;
                }
                return $this->cargos;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerPuestos($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT * FROM puestos WHERE id=$id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function SelectPuesto()
    {
        $sql = "SELECT * FROM puestos WHERE estado=1";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->cargos[] = $row;
                }
                return $this->cargos;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }

    public function InsertarCargos($nombre, $perfil, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->obtenerNuevoId($Puesto = "puestos");
        $codigo = $this->GenerarCodigo($id, $nombre);
        $nombre = $this->db->real_escape_string($nombre);
        $perfil = $this->db->real_escape_string($perfil);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO puestos (id,codigo, nombre, perfil, descripcion,estado) VALUES ($id,'$codigo', '$nombre', '$perfil', '$descripcion','$estado')";

        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarCargos($id, $nombre, $perfil, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            return false; // ID no válido
        }


        $nombre = $this->db->real_escape_string($nombre);
        $perfil = $this->db->real_escape_string($perfil);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "UPDATE puestos SET  nombre = '$nombre', perfil = '$perfil', descripcion = '$descripcion', estado = '$estado' WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    public function CambiarEstadoCargos($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE puestos SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    /***
     * Gestion de colaboradores
     */
    public function index()
    {
        $sql = "SELECT e.id AS IdEmpleado,e.cod_trabajador, e.codigo_inss,ec.nombre_estado,e.estado,p.nombre As NombrePersona,
        p.telefono,p.correo,p.foto, pr.nombre As punto, m.nombre AS municipio,d.nombre AS departamento,
        pn.apellido,pn.tipo_identificacion,pn.identificacion,pn.fecha_nacimiento,
        g.nombre AS genero, ps.nombre AS nacionalidad
        FROM empleado e
        INNER JOIN persona  p ON  p.id = e.id_persona
        LEFT JOIN persona_natural pn ON p.id= pn.id_persona
        LEFT JOIN estado_civil ec ON e.id_estado_civil = ec.id
        LEFT JOIN puntos_referencia pr ON p.id_punto_referencia = pr.id
        LEFT JOIN genero g ON pn.id_genero =g.id
        LEFT JOIN municipio m ON pr.cod_municipio = m.id
        LEFT JOIN departamento d ON m.cod_departamento = d.id
        LEFT JOIN pais ps ON pn.id_nacionalidad = ps.id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->empleado[] = $row;
                }
                return $this->empleado;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    /**
     * Funcion para mostrar los datos a actualizar
     */
    public function ObtenerEmpleado($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT e.id AS IdEmpleado,e.cod_trabajador, e.codigo_inss,ec.nombre_estado,e.estado,p.nombre As NombrePersona,
        p.telefono,p.correo,p.foto,pr.id AS domicilio, pr.nombre As punto, m.nombre AS municipio,d.nombre AS departamento,
        pn.apellido,pn.tipo_identificacion,pn.identificacion,pn.fecha_nacimiento,
        g.nombre AS genero,g.id As sexo, ps.nombre AS nacionalidad,
        m.id AS municipios, ec.id AS IdEstado, ps.id AS paises,
        pr.id AS referencia,p.id AS IdPersona,pn.id AS personaNatural
        FROM empleado e
        INNER JOIN persona  p ON  p.id = e.id_persona
        LEFT JOIN persona_natural pn ON p.id= pn.id_persona
        LEFT JOIN estado_civil ec ON e.id_estado_civil = ec.id
        LEFT JOIN puntos_referencia pr ON p.id_punto_referencia = pr.id
        LEFT JOIN genero g ON pn.id_genero =g.id
        LEFT JOIN municipio m ON pr.cod_municipio = m.id
        LEFT JOIN departamento d ON m.cod_departamento = d.id
        LEFT JOIN pais ps ON pn.id_nacionalidad = ps.id
        Where e.id= $id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function GenerarCodigoTrabajador()
    {
        do {
            $numeroAleatorio = rand(10000, 99999);
            $codigoTrabajador = str_pad($numeroAleatorio, 5, '0', STR_PAD_LEFT); // Asegura que el código tenga 5 dígitos
            $consulta = $this->db->query("SELECT cod_trabajador FROM empleado WHERE cod_trabajador = '$codigoTrabajador'");
        } while ($consulta->num_rows > 0);

        return $codigoTrabajador;
    }
    public function InsertarEmpleado($id_persona, $id_estado_civil, $codigo_inss, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->obtenerNuevoId($Puesto = "empleado");
        $id_persona = filter_var($id_persona, FILTER_VALIDATE_INT);
        $id_estado_civil = filter_var($id_estado_civil, FILTER_VALIDATE_INT);
        $cod_trabajador = $this->GenerarCodigoTrabajador();
        $codigo_inss = $this->db->real_escape_string($codigo_inss);

        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO empleado (id,id_persona, id_estado_civil, cod_trabajador, codigo_inss, fecha_registro, estado) 
            VALUES ($id,$id_persona, $id_estado_civil, '$cod_trabajador', '$codigo_inss',NOW(), $estado)";

        if ($this->db->query($sql)) {
            return "Registro insertado correctamente";
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarEmpleado($id, $id_estado_civil, $codigo_inss, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $id_estado_civil = filter_var($id_estado_civil, FILTER_VALIDATE_INT);

        $codigo_inss = $this->db->real_escape_string($codigo_inss);

        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE empleado SET  id_estado_civil = $id_estado_civil, 
                codigo_inss = '$codigo_inss', 
              estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return "Registro actualizado correctamente";
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoEmpleado($id, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE empleado SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    /**
     * Salarios
     * 
     */
    public function IndexSalarios()
    {
        $sql = "SELECT e.id, e.cod_trabajador, p.nombre, pn.apellido,s.id AS id_salario, s.salario,s.fecha_registro, s.estado FROM empleado e
                INNER JOIN persona p ON p.id = e.id_persona
                LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
                LEFT JOIN salarios s ON e.id  = s.id_empleado
                WHERE e.estado = 1 AND s.estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->salarios[] = $row;
                }
                return $this->salarios;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerDetallesEmpleadoConSalarios($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT e.id, e.cod_trabajador, p.nombre, p.foto, pn.apellido FROM empleado e
                INNER JOIN persona p ON p.id = e.id_persona
                LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
                WHERE e.estado = 1 AND e.id = $Id";
        $resultado = $this->db->query($sql);

        $detallesEmpleado = [];

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();

            // Almacena los detalles del empleado
            $detallesEmpleado['id'] = $row['id'];
            $detallesEmpleado['cod_trabajador'] = $row['cod_trabajador'];
            $detallesEmpleado['nombre'] = $row['nombre'];
            $detallesEmpleado['apellido'] = $row['apellido'];
            $detallesEmpleado['foto'] = $row['foto'];

            // Ahora, obtén los salarios asociados al empleado
            $detallesEmpleado['salarios'] = $this->ObtenerSalariosEmpleado($Id);
        }

        return $detallesEmpleado;
    }

    public  function ObtenerSalariosEmpleado($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT s.id AS id_salario, s.salario, s.fecha_registro AS fecha_registro_salario, s.estado, s.fecha_cambio FROM salarios s
                WHERE s.id_empleado = $Id ORDER BY s.estado ASC";
        $resultado = $this->db->query($sql);

        $salarios = [];

        while ($row = $resultado->fetch_assoc()) {
            $salarios[] = $row;
        }

        return $salarios;
    }

    public function MostraEmpleadosSinSalarios()
    {
        $sql = "SELECT e.id, e.cod_trabajador, p.nombre, pn.apellido FROM empleado e
        INNER JOIN persona p ON p.id = e.id_persona
        LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
        WHERE e.estado = 1 AND NOT EXISTS (SELECT id_empleado FROM salarios s WHERE s.id_empleado = e.id)";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->salarios[] = $row;
                }
                return $this->salarios;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerEmpleadosConSalario($IdSalario)
    {
        $IdSalario = filter_var($IdSalario, FILTER_VALIDATE_INT);
        $sql = "SELECT e.id AS IdEmpleado, e.cod_trabajador, p.nombre, pn.apellido FROM empleado e
        INNER JOIN persona p ON p.id = e.id_persona
        LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
        LEFT JOIN salarios s ON e.id  = s.id_empleado
        WHERE e.estado = 1 AND s.id = $IdSalario";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function InsertarSalarioColaborador($IdEmpleado, $salario, $estado)
    {
        $persona = new Persona_model();

        $id = $persona->obtenerNuevoId("salarios");
        $idEmpleado = filter_var($IdEmpleado, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $fecha_registro = date('Y-m-d');
        $sql = "INSERT INTO salarios (id, id_empleado, salario, fecha_registro, estado) VALUES ($id, $idEmpleado, $salario, '$fecha_registro', $estado)";
        $this->db->query($sql);
    }

    public function CambiarEstadoSalario($IdSalario, $estado)
    {
        $IdSalario = filter_var($IdSalario, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $FechaCambio = date('Y-m-d');
        $sql = "UPDATE salarios
            SET estado = $estado , fecha_cambio= '$FechaCambio'
            WHERE id = $IdSalario";
        if ($this->db->query($sql)) {
            return "Estado actualizado correctamente";
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }


    /**
     * Historial de cargos
     */
    public function MostrarHistorialCargo()
    {
        $sql = "SELECT Hc.*,e.cod_trabajador,ps.nombre AS cargos,p.nombre,pn.apellido,  COUNT(Hc.id)  AS numeros FROM historial_cargos Hc 
        INNER JOIN empleado e ON  e.id = HC.id_empleado
        INNER JOIN puestos ps ON ps.id = HC.id_cargo
        LEFT JOIN persona p ON e.id_persona = p.id
        LEFT JOIN persona_natural pn ON p.id = pn.id_persona
        WHERE Hc.estado =1  
        GROUP BY
        e.cod_trabajador, p.nombre, pn.apellido";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->Asignacion[] = $row;
            }
            return $this->Asignacion;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function ObtenerDetallesEmpleadoConCargos($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT e.id, e.cod_trabajador, p.nombre, p.foto, pn.apellido FROM empleado e
                INNER JOIN persona p ON p.id = e.id_persona
                LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
                WHERE e.estado = 1 AND e.id = $Id";
        $resultado = $this->db->query($sql);

        $detallesEmpleado = [];

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();

            // Almacena los detalles del empleado
            $detallesEmpleado['id'] = $row['id'];
            $detallesEmpleado['cod_trabajador'] = $row['cod_trabajador'];
            $detallesEmpleado['nombre'] = $row['nombre'];
            $detallesEmpleado['apellido'] = $row['apellido'];
            $detallesEmpleado['foto'] = $row['foto'];

            // Ahora, obtén los salarios asociados al empleado
            $detallesEmpleado['cargos'] = $this->ObtenerHistorialCargoEmpleado($Id);
        }

        return $detallesEmpleado;
    }
    public function ObtenerHistorialCargoEmpleado($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT Hc.*, p.nombre AS cargo, p.descripcion,p.perfil FROM historial_cargos Hc 
        INNER JOIN puestos p ON p.id = Hc.id_cargo 
        WHERE hc.id_empleado =  $Id";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->Asignacion[] = $row;
            }
            return $this->Asignacion;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function CargosSinEmpleados($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT * FROM puestos p
        WHERE p.estado = 1 AND NOT EXISTS  (SELECT * FROM historial_cargos hc WHERE p.id =hc.id_cargo AND hc.id_empleado = $Id )";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Asignacion[] = $row;
                }
                return $this->Asignacion;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function EmpleadoSinCargos()
    {
        $sql = "SELECT e.id, e.cod_trabajador,p.nombre,pn.apellido FROM empleado e 
        LEFT JOIN persona p ON e.id_persona = p.id
        LEFT JOIN persona_natural pn ON p.id = pn.id_persona
        WHERE e.estado = 1 AND NOT EXISTS  (SELECT * FROM historial_cargos hc WHERE e.id =hc.id_empleado )";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Asignacion[] = $row;
                }
                return $this->Asignacion;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }

    public function InsertarHistorialCargo($id_cargo, $id_empleado, $estado)
    {
        $Persona = new Persona_model();
        $Id = $Persona->obtenerNuevoId($tabla = "historial_cargos");
        $id_cargo = filter_var($id_cargo, FILTER_VALIDATE_INT);
        $id_empleado = filter_var($id_empleado, FILTER_VALIDATE_INT);

        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO historial_cargos (id,id_cargo, id_empleado, fecha_registro, estado) 
            VALUES ($Id,$id_cargo, $id_empleado,NOW(), $estado)";

        if ($this->db->query($sql)) {
            return "Registro insertado correctamente";
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarHistorialCargo($id_historial, $id_cargo, $id_empleado, $fecha_registro, $estado)
    {
        $id_historial = filter_var($id_historial, FILTER_VALIDATE_INT);
        $id_cargo = filter_var($id_cargo, FILTER_VALIDATE_INT);
        $id_empleado = filter_var($id_empleado, FILTER_VALIDATE_INT);
        $fecha_registro = $this->db->real_escape_string($fecha_registro);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE historial_cargos 
            SET id_cargo = $id_cargo, 
                id_empleado = $id_empleado, 
                fecha_registro = '$fecha_registro', 
                estado = $estado 
            WHERE id = $id_historial";

        if ($this->db->query($sql)) {
            return "Registro actualizado correctamente";
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoHistorialCargo($id_historial, $estado)
    {
        $id_historial = filter_var($id_historial, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE historial_cargos 
            SET estado = $estado 
            WHERE id = $id_historial";

        if ($this->db->query($sql)) {
            return "Estado actualizado correctamente";
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function MostrarContratos()
    {
        $sql = "SELECT c.id,c.codigo,c.tomo,c.folio,tc.nombre AS tipo_contrato,c.contrato,c.fecha_registro,c.fecha_cambio,c.fecha_vencimiento,c.estado,e.id AS empleado,e.cod_trabajador,p.foto,p.nombre,pn.apellido FROM contratos c
        INNER JOIN empleado e ON e.id = c.id_empleado
        LEFT JOIN persona p ON e.id_persona = p.id
        LEFT JOIN persona_natural pn ON p.id = pn.id_persona
        LEFT JOIN tipo_contratos tc ON c.id_tipo = tc.id
        WHERE c.estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->contratos[] = $row;
                }
                return $this->contratos;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function MostrarEmpleandoSinContratos()
    {
        $sql = "SELECT e.id, e.cod_trabajador,p.nombre,pn.apellido FROM empleado e 
         LEFT JOIN persona p ON e.id_persona = p.id
         LEFT JOIN persona_natural pn ON p.id = pn.id_persona
         WHERE e.estado = 1 AND NOT EXISTS  (SELECT * FROM contratos c WHERE e.id =c.id_empleado )";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->contratos[] = $row;
                }
                return $this->contratos;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerContratosActualizar($id)
    {
        $Id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT c.*,e.id AS id_empleado,p.nombre,pn.apellido,e.cod_trabajador FROM contratos c
        INNER JOIN empleado e ON e.id = c.id_empleado
        LEFT JOIN persona p ON e.id_persona = p.id
        LEFT JOIN persona_natural pn ON pn.id_persona = p.id WHERE c.id = $Id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function TiposContratos()
    {
        $sql = "SELECT * FROM tipo_contratos WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->TipoContratos[] = $row;
        }
        return $this->TipoContratos;
    }
    public function CrearContrato($id_tipo, $id_empleado, $codigo, $tomo, $folio, $contrato, $fecha_vencimiento)
    {
        $Persona = new Persona_model();
        $id = $Persona->obtenerNuevoId($tabla = "contratos");
        $id_empleado = filter_var($id_empleado, FILTER_VALIDATE_INT);
        $id_tipo = filter_var($id_tipo, FILTER_VALIDATE_INT);
        $codigo = $this->db->real_escape_string($codigo);
        $tomo = $this->db->real_escape_string($tomo);
        $folio = $this->db->real_escape_string($folio);
        $contrato = $this->db->real_escape_string($contrato);
        $fecha_vencimiento = $this->db->real_escape_string($fecha_vencimiento);

        $sql = "INSERT INTO contratos (id,id_tipo,id_empleado, codigo, tomo, folio, contrato, fecha_vencimiento) 
                VALUES ($id,$id_tipo,$id_empleado, '$codigo', '$tomo', '$folio', '$contrato', '$fecha_vencimiento')";

        if ($this->db->query($sql)) {
            return "Contrato creado correctamente";
        } else {
            return "Error al crear el contrato: " . $this->db->error;
        }
    }

    public function ActualizarContrato($id_contrato, $tipo_contrato, $codigo, $tomo, $folio,  $contrato, $fecha_vencimiento)
    {
        $id_contrato = filter_var($id_contrato, FILTER_VALIDATE_INT);
        $codigo = $this->db->real_escape_string($codigo);
        $tomo = $this->db->real_escape_string($tomo);
        $folio = $this->db->real_escape_string($folio);
        $tipo_contrato = $this->db->real_escape_string($tipo_contrato);
        $contrato = $this->db->real_escape_string($contrato);
        $fecha_vencimiento = $this->db->real_escape_string($fecha_vencimiento);

        $sql = "UPDATE contratos 
                SET  id_tipo = $tipo_contrato ,codigo = '$codigo', tomo = '$tomo', folio = '$folio', contrato = '$contrato', fecha_vencimiento = '$fecha_vencimiento'
                WHERE id = $id_contrato";

        if ($this->db->query($sql)) {
            return "Contrato actualizado correctamente";
        } else {
            return "Error al actualizar el contrato: " . $this->db->error;
        }
    }

    public function CambiarEstadoContrato($id_contrato, $estado)
    {
        // Se filtran y validan los parámetros de entrada como enteros.
        $id_contrato = filter_var($id_contrato, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        // Se construye la consulta SQL para actualizar el estado de un contrato.
        $sql = "UPDATE contratos SET estado = $estado, fecha_cambio = NOW() WHERE id_empleado = $id_contrato AND estado = 1";

        // Se ejecuta la consulta en la base de datos.
        if ($this->db->query($sql)) {
            // Si la consulta se ejecuta correctamente, se devuelve un mensaje de éxito.
            return "Estado del contrato cambiado correctamente";
        } else {
            // Si hay un error en la consulta, se devuelve un mensaje de error que incluye detalles del error.
            return "Error al cambiar el estado del contrato: " . $this->db->error;
        }
    }

    public function BuscarNombreyApellido($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT persona.nombre, persona_natural.apellido 
        FROM empleado
        INNER JOIN persona ON empleado.id_persona = persona.id
        INNER JOIN persona_natural ON empleado.id_persona = persona_natural.id_persona
        WHERE empleado.id='$Id'";

        $result = $this->db->query($sql);

        if ($result->num_rows == 1) {
            $fila = $result->fetch_assoc();
            return $fila; // Devuelve el array asociativo con el nombre y apellido
        }

        return [];
    }
    public function ObtenerDetallesEmpleadoContratos($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT e.id, e.cod_trabajador, p.nombre, p.foto, pn.apellido FROM empleado e
                INNER JOIN persona p ON p.id = e.id_persona
                LEFT JOIN persona_natural pn ON e.id_persona = pn.id_persona
                WHERE e.estado = 1 AND e.id = $Id";
        $resultado = $this->db->query($sql);

        $detallesEmpleado = [];

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();

            // Almacena los detalles del empleado
            $detallesEmpleado['id'] = $row['id'];
            $detallesEmpleado['cod_trabajador'] = $row['cod_trabajador'];
            $detallesEmpleado['nombre'] = $row['nombre'];
            $detallesEmpleado['apellido'] = $row['apellido'];
            $detallesEmpleado['foto'] = $row['foto'];

            // Ahora, obtén los salarios asociados al empleado
            $detallesEmpleado['contratos'] = $this->ObtenerContratosEmpleado($Id);
        }

        return $detallesEmpleado;
    }

    public function ObtenerContratosEmpleado($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT s.*, tc.nombre AS tipo 
        FROM contratos s
        INNER JOIN tipo_contratos tc ON tc.id = s.id_tipo    
        WHERE s.id_empleado = $Id 
        ORDER BY s.estado ASC;
        ";
        $resultado = $this->db->query($sql);

        $salarios = [];

        while ($row = $resultado->fetch_assoc()) {
            $salarios[] = $row;
        }

        return $salarios;
    }
}
