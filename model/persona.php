<?php

class Persona_model
{
    private $db;
    private $EstadoCivil;
    private $Genero;
    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->EstadoCivil = array();
        $this->Genero = array();
    }
    public function obtenerNuevoId($nombreTabla)
    {
        $query = "SELECT MAX(id) AS max_id FROM $nombreTabla";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()['max_id'] + 1;
        }
        return 1;
    }

    public function InsertarPersona($nombre, $telefono, $id_domicilio, $correo, $foto)
    {
        $id = $this->obtenerNuevoId($Persona = "persona");
        $nombre = $this->db->real_escape_string($nombre);
        $telefono = filter_var($telefono, FILTER_VALIDATE_INT);
        $id_domicilio = filter_var($id_domicilio, FILTER_VALIDATE_INT);
        $correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
        $foto = $this->db->real_escape_string($foto);
        $sql = "INSERT INTO persona (id, nombre, telefono, id_punto_referencia, correo, foto) VALUES ('$id', '$nombre', '$telefono', '$id_domicilio', '$correo', '$foto')";
        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarPersona($id, $nombre, $telefono, $id_punto_referencia, $correo, $foto)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $telefono = filter_var($telefono, FILTER_VALIDATE_INT);
        $id_punto_referencia = filter_var($id_punto_referencia, FILTER_VALIDATE_INT);
        $correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
        $foto = $this->db->real_escape_string($foto);

        $sql = "UPDATE persona SET nombre='$nombre', telefono=$telefono, id_punto_referencia=$id_punto_referencia, correo='$correo', foto='$foto' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }


    public function InsertarPersonaNatural($id_persona, $id_nacionalidad, $id_genero, $apellido, $tipo_identificacion, $identificacion, $fecha_nacimiento)
    {
        $id = $this->obtenerNuevoId($Persona = "persona_natural");

        $apellido = $this->db->real_escape_string($apellido);
        $tipo_identificacion = $this->db->real_escape_string($tipo_identificacion);
        $identificacion = $this->db->real_escape_string($identificacion);
        $fecha_nacimiento = $this->db->real_escape_string($fecha_nacimiento);

        $sql = "INSERT INTO persona_natural (id, id_persona, id_nacionalidad, id_genero, apellido, tipo_identificacion, identificacion, fecha_nacimiento) VALUES ($id, $id_persona, $id_nacionalidad, $id_genero, '$apellido', '$tipo_identificacion', '$identificacion', '$fecha_nacimiento')";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }




    public function InsertarPersonaJuridica($id_persona, $fecha_constitucional, $numero_ruc, $razon_social)
    {
        $id = $this->obtenerNuevoId($Persona = "persona_juridica");
        $fecha_constitucional = $this->db->real_escape_string($fecha_constitucional);
        $numero_ruc = $this->db->real_escape_string($numero_ruc);
        $razon_social = $this->db->real_escape_string($razon_social);

        $sql = "INSERT INTO persona_juridica (id, id_persona, fecha_constitucional, numero_ruc, razon_social) VALUES ($id, $id_persona, '$fecha_constitucional', '$numero_ruc', '$razon_social')";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizaPersonaNatural($id_persona, $id_nacionalidad, $id_genero, $apellido, $tipo_identificacion, $identificacion, $fecha_nacimiento)
    {
        $id_persona = filter_var($id_persona, FILTER_VALIDATE_INT);

        if (!$id_persona) {
            return false; // ID no válido
        }

        $apellido = $this->db->real_escape_string($apellido);
        $tipo_identificacion = $this->db->real_escape_string($tipo_identificacion);
        $identificacion = $this->db->real_escape_string($identificacion);
        $fecha_nacimiento = $this->db->real_escape_string($fecha_nacimiento);
   
        $sql = "UPDATE persona_natural SET id_nacionalidad = $id_nacionalidad, id_genero = $id_genero, apellido = '$apellido', tipo_identificacion = '$tipo_identificacion', identificacion = '$identificacion', fecha_nacimiento = '$fecha_nacimiento' WHERE id = $id_persona";
    
        if ($this->db->query($sql)) {
           
            return $id_persona;
        } else {
           
            return "Error al realizar la actualización: " . $this->db->error;
           
        }
    }


    public function ActualizaPersonaJuridica($id, $id_persona, $fecha_constitucional, $numero_ruc, $razon_social)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            return false; // ID no válido
        }

        $fecha_constitucional = $this->db->real_escape_string($fecha_constitucional);
        $numero_ruc = $this->db->real_escape_string($numero_ruc);
        $razon_social = $this->db->real_escape_string($razon_social);

        $sql = "UPDATE persona_juridica SET id_persona = $id_persona, fecha_constitucional = '$fecha_constitucional', numero_ruc = '$numero_ruc', razon_social = '$razon_social' WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function InsertarPuntoReferencia($nombre, $descripcion, $cod_municipio)
    {
        // Supongo que tienes un modelo para la tabla puntos_referencia
        $id = $this->obtenerNuevoId($Tabla = "puntos_referencia"); // Asumiendo que tienes una función para obtener un nuevo ID

        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $cod_municipio = filter_var($cod_municipio, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO puntos_referencia (id, nombre, descripcion, cod_municipio) VALUES ($id, '$nombre', '$descripcion', $cod_municipio)";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarPuntoReferencia($id, $nombre, $descripcion, $cod_municipio)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $cod_municipio = filter_var($cod_municipio, FILTER_VALIDATE_INT);

        $sql = "UPDATE puntos_referencia SET nombre = '$nombre', descripcion = '$descripcion', cod_municipio = $cod_municipio WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    /**
     * Funcion para el front end
     */
    public function SelectGenero()
    {
        $sql = "SELECT id,nombre FROM genero WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Genero[] = $row;
        }
        return $this->Genero;
    }

    public function SelectEstadoCivil()
    {
        $sql = "SELECT id,nombre_estado AS nombre FROM estado_civil WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->EstadoCivil[] = $row;
        }
        return $this->EstadoCivil;
    }
    public function ObtenerDepartamentosConMunicipios()
    {
        $sql = "SELECT d.nombre as departamento, m.id as id_municipio, m.nombre as municipio
      FROM departamento d
      JOIN municipio m ON d.id = m.cod_departamento
      WHERE d.estado = 1 AND m.estado = 1";

        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $departamentos = array();

            while ($row = $result->fetch_assoc()) {
                $departamento = $row["departamento"];
                $id_municipio = $row["id_municipio"];
                $municipio = $row["municipio"];

                if (!isset($departamentos[$departamento])) {
                    $departamentos[$departamento] = array();
                }

                $departamentos[$departamento][] = array(
                    'id' => $id_municipio,
                    'nombre' => $municipio
                );
            }

            return $departamentos;
        } else {
            return "No se encontraron resultados";
        }
    }
    public function pais()
    {
        $sql = "SELECT * FROM pais WHERE estado=1";
        $resultado = $this->db->query($sql);
        $pais = array();
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $pais[] = $row;
            }
        }
        return $pais;
    }
}
