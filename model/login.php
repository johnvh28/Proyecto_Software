<?php
require 'vendor/autoload.php';

use UAParser\Parser;

class Login_Model
{
    private $db;
    private $PrivilegiosModulos;

    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->PrivilegiosModulos = array();
    }
    public function ValidarUsuarios($Usuario)
    {
        $Usuario = $this->db->real_escape_string($Usuario);
        $sql = "SELECT id,usuario FROM usuario WHERE usuario='$Usuario' AND estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            $User = $resultado->fetch_assoc();
            return $Id = $User['id'];
        } else {
            return false;
        }
    }
    public function ValidarPerfil($Id)
    {
        $Id = $this->db->real_escape_string($Id);
        $sql = "SELECT id_rol FROM usuario WHERE id='$Id' AND estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            $User = $resultado->fetch_assoc();
            $IdRol = $User['id_rol'];
            $sql = "SELECT id_perfil FROM rol WHERE id='$IdRol'";
            $resultado = $this->db->query($sql);
            if ($resultado->num_rows > 0) {
                $User = $resultado->fetch_assoc();
                $IdPerfil = $User['id_perfil'];
                return $IdPerfil;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function ValidarContraseña($Id, $Contraseña)
    {
        $Id = FILTER_VAR($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT contraseña from detalle_usuario WHERE id_usuario = $Id AND estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $contraseña_hash = $fila['contraseña'];
            if (password_verify($Contraseña, $contraseña_hash)) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function DatosUsuarios($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT id_persona FROM usuario WHERE id = $Id";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $id_persona = $fila['id_persona'];
        /**
         * Nombre y foto de la tabla persona
         */
        $Persona = "SELECT nombre, foto FROM persona WHERE id=$id_persona ";
        $ResultadoPersona = $this->db->query($Persona);
        $fila = $ResultadoPersona->fetch_assoc();
        $Nombre = $fila['nombre'];
        $Foto  = $fila['foto'];
        /**
         * Apellido de la persona natural
         */
        $PersonaNatural = "SELECT apellido FROM persona_natural WHERE id_persona = $id_persona";
        $ResultadoPersonaNatural = $this->db->query($PersonaNatural);
        $fila = $ResultadoPersonaNatural->fetch_assoc();
        $Apellido = $fila['apellido'];
        /**
         * codigo empleado desde la tabla empleado
         */
        $Empleado = "SELECT id,cod_trabajador FROM empleado WHERE id_persona = $id_persona";
        $ResultadoEmpleado = $this->db->query($Empleado);
        $fila = $ResultadoEmpleado->fetch_assoc();
        $IdEmpleado=$fila['id'];
        $Codigo = $fila["cod_trabajador"];

        return array("Nombre" => $Nombre, "Apellido" => $Apellido, "Foto" => $Foto, "Codigo" => $Codigo,"IdEmpleado"=>$IdEmpleado);
    }
    public function datosUsuariosclientes($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT id_persona FROM usuario WHERE id = $Id";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $id_persona = $fila['id_persona'];
        /**
         * Nombre y foto de la tabla persona
         */
        $Persona = "SELECT nombre, foto FROM persona WHERE id=$id_persona ";
        $ResultadoPersona = $this->db->query($Persona);
        $fila = $ResultadoPersona->fetch_assoc();
        $Nombre = $fila['nombre'];
        $Foto  = $fila['foto'];
        /**
         * Apellido de la persona natural
         */
        $PersonaNatural = "SELECT apellido FROM persona_natural WHERE id_persona = $id_persona";
        $ResultadoPersonaNatural = $this->db->query($PersonaNatural);
        $fila = $ResultadoPersonaNatural->fetch_assoc();
        $Apellido = $fila['apellido'];
        /**
         * codigo empleado desde la tabla empleado
         */
      

        return array("Nombre" => $Nombre, "Apellido" => $Apellido, "Foto" => $Foto);
    }
    public function ObtenerPrivilegio($Id)
    {
        $privilegios = array();
        $Id = FILTER_VAR($Id, FILTER_VALIDATE_INT);
        // Obtener los privilegios del usuario
        $query = "SELECT pr.id_sub_modulo,m.id AS id_modulo, m.nombre AS modulo, m.icono, sm.nombre AS submodulo, sm.enlace FROM privilegio_rol pr 
        INNER JOIN rol r ON r.id =pr.id_usuario
        INNER JOIN sub_modulo sm ON  sm.id = pr.id_sub_modulo
        INNER JOIN modulo m ON m.id = sm.id_modulo
        LEFT JOIN usuario U ON r.id = U.id_rol
        LEFT JOIN usuario US ON pr.autorizacion = US.id
        WHERE u.id =$Id AND r.estado = 1";
        $result = $this->db->query($query);

        // Organizar los privilegios en un array de modulos y submodulos
        $modulos = array();
        while ($row = $result->fetch_assoc()) {
            $modulo_id = $row['id_modulo'];
            $submodulo_id = $row['id_sub_modulo'];
            if (!isset($modulos[$modulo_id])) {
                $modulos[$modulo_id] = array(
                    'id' => $modulo_id,
                    'nombre' => $row['modulo'],
                    'icono' => $row['icono'],
                    'submodulos' => array()
                );
            }
            if (!empty($submodulo_id)) {
                $submodulo = array(
                    'id' => $submodulo_id,
                    'nombre' => $row['submodulo'],
                    'enlace' => $row['enlace']
                );
                $modulos[$modulo_id]['submodulos'][] = $submodulo;
            }
        }

        $privilegios = $modulos;
        return $privilegios;
    }
    public function ObtenerPrivilegioTemporales($Id)
    {
        $privilegios = array();
        $Id = FILTER_VAR($Id, FILTER_VALIDATE_INT);
        // Obtener los privilegios del usuario
        $query = "SELECT pr.id_sub_modulo, m.id AS id_modulo, m.nombre AS modulo, m.icono, sm.nombre AS submodulo, sm.enlace, rt.id_rol AS id_rol_temporal
        FROM privilegio_rol pr 
        INNER JOIN sub_modulo sm ON sm.id = pr.id_sub_modulo
        INNER JOIN modulo m ON m.id = sm.id_modulo
        LEFT JOIN roles_temporales rt ON rt.id_rol = pr.id_usuario
        LEFT JOIN usuario u ON rt.id = u.id_rol
        WHERE rt.id_usuario = $Id AND rt.estado = 1";
        $result = $this->db->query($query);

        // Organizar los privilegios en un array de modulos y submodulos
        $modulos = array();
        while ($row = $result->fetch_assoc()) {
            $modulo_id = $row['id_modulo'];
            $submodulo_id = $row['id_sub_modulo'];
            if (!isset($modulos[$modulo_id])) {
                $modulos[$modulo_id] = array(
                    'id' => $modulo_id,
                    'nombre' => $row['modulo'],
                    'icono' => $row['icono'],
                    'submodulos' => array()
                );
            }
            if (!empty($submodulo_id)) {
                $submodulo = array(
                    'id' => $submodulo_id,
                    'nombre' => $row['submodulo'],
                    'enlace' => $row['enlace']
                );
                $modulos[$modulo_id]['submodulos'][] = $submodulo;
            }
        }

        $privilegios = $modulos;
        return $privilegios;
    }
    /**
     * Datos para monitoreo de usuarios
     * 
     */
    public function obtenerInformacionNavegador()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $parser = Parser::create();
        $result = $parser->parse($ua);           // 2
        $result->ua->toString();        // Safari 6.0.2
        $result->ua->toVersion();       // 6.0.2
        $result->os->toString();        // Mac OS X 10.7.5
        $result->os->toVersion();       // 10.7.5
        return array(
            'navegador' =>  $result->ua->toString(),
            'version_navegador' =>  $result->ua->toVersion(),
            'os' =>   $result->os->toString(),
            'version_os' =>  $result->os->toVersion()
        );
    }
}
