<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once  "model/persona.php";
class Usuarios_Model
{
    private $db;
    private $rol;
    private $empleado;
    private $usuario;
    private $conexion;
    private $privilegios;
    private $historicos;


    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->rol = array();
        $this->empleado = array();
        $this->usuario = array();
        $this->conexion = array();
        $this->privilegios = array();
        $this->historicos = array();
    }
    /**
     * Roles
     */
    public function MostrarRol()
    {
        $sql = " SELECT r.*,p.nombre AS perfil FROM rol r INNER JOIN perfil p ON p.id = r.id_perfil";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
            return $this->rol;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function GenerarCodigoRol()
    {
        $longitudCodigo = 8;
        $caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        do {
            // Genera un código único utilizando el formato deseado
            $codigo = 'R' . substr(str_shuffle($caracteresPermitidos), 0, $longitudCodigo);
        } while ($this->CodigoExisteEnLaBaseDeDatos($codigo, $tabla = 'rol'));

        return $codigo;
    }

    private function CodigoExisteEnLaBaseDeDatos($codigo, $tabla)
    {
        // Lógica para verificar si el código ya existe en la base de datos
        $consulta = $this->db->query("SELECT COUNT(*) FROM $tabla WHERE codigo = '$codigo'");
        $conteo = $consulta->fetch_row()[0];
        $consulta->close();
        return $conteo > 0;
    }
    public function Perfil()
    {
        $sql = "SELECT * FROM perfil WHERE estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
            return $this->rol;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function ObtenerRolId($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $squery = "SELECT r.* FROM rol r 
        INNER JOIN perfil p ON p.id=r.id_perfil
          WHERE r.id = $Id";
        $resultado = $this->db->query($squery);
        $row = $resultado->fetch_assoc();
        return $row;
    }

    public function InsertarRol($IdPerfil, $nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($rol = "rol");
        $codigo = $this->GenerarCodigoRol();
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $IdPerfil = filter_var($IdPerfil, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO rol (id,id_perfil,codigo,nombre,descripcion,fecha_registro,estado) VALUES($id,$IdPerfil,'$codigo','$nombre','$descripcion',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarRol($id, $IdPerfil, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $IdPerfil = filter_var($IdPerfil, FILTER_VALIDATE_INT);
        $sql = "UPDATE rol SET id_perfil=$IdPerfil,nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoRol($id, $estado,)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE rol SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    /**
     * Usuarios
     */
    public function MostrarUsuarios()
    {
        $sql = "SELECT u.*,r.nombre AS roles, p.nombre,pn.apellido, e.cod_trabajador FROM usuario u
        INNER JOIN persona p ON p.id = u.id_persona
        LEFT JOIN rol r ON u.id_rol = r.id
        LEFT JOIN empleado e ON p.id = e.id_persona
        LEFT JOIN persona_natural pn ON p.id=pn.id_persona";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
            return $this->rol;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function ObtenerUsuarioId($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $squery = "SELECT u.* FROM usuario u 
          WHERE u.id = $Id";
        $resultado = $this->db->query($squery);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function ObtenerNombreEmpleado($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT r.nombre AS rol,p.foto,u.usuario, e.cod_trabajador, p.nombre,pn.apellido FROM usuario u
        LEFT JOIN empleado e ON u.id_persona =e.id_persona
        LEFT JOIN persona p ON e.id_persona = p.id
        LEFT JOIN persona_natural pn ON p.id = pn.id_persona
        LEFT JOIN rol r ON u.id_rol = r.id
        WHERE u.id = $Id";
        $resultados=$this->db->query($sql);
        $row=$resultados->fetch_assoc();
        return $row;
    }
    public function ObtenerRolesHistoricos($Id)
    {  
        $Id=filter_var($Id,FILTER_VALIDATE_INT);
        $sql="SELECT rt.*, us.usuario AS autorizado,r.nombre AS rol FROM roles_temporales rt  
        JOIN rol r ON rt.id_rol = r.id
         JOIN usuario e ON e.id = rt.id_usuario
         JOIN usuario us ON rt.autorizado =us.id
        WHERE e.id =  $Id";
        $resultado =$this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->historicos[] = $row;
            }
            return $this->historicos;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function MostrarUsuariosSinVerificar()
    {
        $sql = "SELECT u.*,r.nombre AS roles, p.nombre,pn.apellido, e.cod_trabajador FROM usuario u
        INNER JOIN persona p ON p.id = u.id_persona
        LEFT JOIN rol r ON u.id_rol = r.id
        LEFT JOIN empleado e ON p.id = e.id_persona
        LEFT JOIN persona_natural pn ON p.id=pn.id_persona
        WHERE  u.estado=2";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->usuario[] = $row;
            }
            return $this->usuario;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function MostrarTrabajadorSinUsuario()
    {
        $sql = "SELECT t.id,t.cod_trabajador, p.nombre, pn.apellido
        FROM persona p
        JOIN persona_natural pn ON p.id = pn.id_persona
        JOIN empleado t ON p.id = t.id_persona
        WHERE NOT EXISTS (
            SELECT * FROM usuario 
            WHERE usuario.id_persona = p.id
        )";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->empleado[] = $row;
                }
                return $this->empleado;
            } else {
                return null; // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function Roles()
    {
        $sql = "SELECT id,nombre FROM rol";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->rol;
        }
        return $this->rol;
    }
    public function RolesSinUsuario($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $sql = "SELECT id, nombre
        FROM rol
        WHERE id NOT IN (
            SELECT id_rol
            FROM roles_temporales
            UNION
            SELECT id_rol
            FROM usuario
            WHERE id = $Id
        )
        ";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->rol;
        }
        return $this->rol;
    }
    public function Roless()
    {
        $sql = "SELECT r.id, r.nombre
        FROM rol r
        LEFT JOIN privilegio_rol pr ON r.id = pr.id_usuario
        WHERE pr.id_usuario IS NULL;";
        $resultado = $this->db->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->rol[] = $row;
            }
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según sea necesario.
            $this->rol;
        }
        return $this->rol;
    }
    public function GenerarCodigoUsuario($longitud = 8)
    {
        do {
            $caracteresPermitidos = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

            $codigo = '';

            $maxCaracteres = strlen($caracteresPermitidos) - 1;

            for ($i = 0; $i < $longitud; $i++) {
                $codigo .= $caracteresPermitidos[random_int(0, $maxCaracteres)];
            }
        } while ($this->CodigoExisteEnLaBaseDeDatos($codigo, $tabla = 'usuario'));
        return $codigo;
    }


    public function InsertarUsuario($id_rol, $id_persona, $usuarios, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($usuario = "usuario");
        $codigo = $this->GenerarCodigoUsuario();
        $id_rol = filter_var($id_rol, FILTER_VALIDATE_INT);
        $id_persona = filter_var($id_persona, FILTER_VALIDATE_INT);
        $usuarios = $this->db->real_escape_string($usuarios);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO usuario (id,id_rol,id_persona,codigo,usuario,fecha_registro,estado) 
        VALUES($id,'$id_rol','$id_persona','$codigo','$usuarios',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return array("Id"=>$id,"Codigo"=>$codigo);
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function obtener_datos($usuario)
    {
        $usuario = $this->db->real_escape_string($usuario);
        $sql = "SELECT nombre,correo FROM persona WHERE id = $usuario";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $nombre = $fila['nombre'];
        $correo = $fila['correo'];
        $sql = "SELECT apellido FROM persona_natural WHERE id_persona = $usuario";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $apellido = $fila['apellido'];
        // Devolver un arreglo asociativo con el nombre, la foto y los submódulos
        return array("nombre" => $nombre, "correo" => $correo,  "apellido" => $apellido);
    }
    public function buscar_usuarios($id)
    {
        $id = $this->db->real_escape_string($id);

        //Retornar el usuarios y el id de la persona
        $sql = "SELECT id_persona, usuario FROM usuario WHERE id= $id";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $usuario = $fila['id_persona'];
        $correo = $fila['usuario'];
        $sql = "SELECT nombre FROM persona WHERE id = $usuario";
        $resultado = $this->db->query($sql);
        $fila = $resultado->fetch_assoc();
        $nombre = $fila['nombre'];

        $sql = "SELECT apellido FROM persona_natural WHERE id_persona = $usuario";
        $resultado = $this->db->query($sql);
        $apellido = $resultado && $resultado->num_rows > 0 ? $resultado->fetch_assoc()['apellido'] : false;


        return array("nombre" => $nombre, "correo" => $correo,  "apellido" => $apellido);
    }
    public function getIdpersona($id_trabajador)
    {

        $sql = "SELECT id_persona FROM empleado WHERE id = " . $id_trabajador;
        $result = $this->db->query($sql);
        if ($result === false) {
            echo $this->db->error;
        }

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            return $row["id_persona"];
        } else {

            return null;
        }
    }
    public function verificacion($email, $code)
    {
        $email = $this->db->real_escape_string($email);
        $code = $this->db->real_escape_string($code);

        $sql = "SELECT id, codigo FROM usuario WHERE usuario = '$email'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $savedCode = $row['codigo'];
            $id = $row['id'];

            if ($code === $savedCode) {
                $this->CambiarEstadoUsuario($id, 1);
                return true;
            }
        }

        return false;
    }
    public function verificar_correo_existente($correo)
    {
        // Realizar una consulta para verificar si el correo ya existe en la base de datos
        $sql = "SELECT COUNT(*) AS existe FROM usuario WHERE usuario = '$correo'";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        return $row['existe'] > 0;
    }
    public function generar_usuarios($nombre, $apellido)
    {
        $intentos = 0;

        do {
          
            $iniciales = substr($nombre, 0, 4) . substr($apellido, 0, 4) . rand(1000, 9999);


            $correo = strtolower($iniciales) . "@SIRCOMD.com";


            $existe_correo = $this->verificar_correo_existente($correo);


            if (!$existe_correo) {
                return $correo;
            }

            $intentos++;

          
            usleep(100000); 
        } while ($intentos < 10); 

        return null; 
    }

    public function generar_contraseña($longitud = 8)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud_caracteres = strlen($caracteres);
        $contraseña = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice_aleatorio = mt_rand(0, $longitud_caracteres - 1);
            $contraseña .= $caracteres[$indice_aleatorio];
        }

        return $contraseña;
    }
    public function ActualizarUsuario($id, $id_rol,  $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_rol = filter_var($id_rol, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE usuario SET id_rol='$id_rol', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoUsuario($id, $estado)
    {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE usuario SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    public function InsertarRolesTemporales($id_rol,$id_usuario,$autorizado)
    {
        $Persona = new Persona_model();
        $Id=$Persona->obtenerNuevoId($nombre="roles_temporales");
        $id_usuario= filter_var($id_usuario,FILTER_VALIDATE_INT);
        $id_rol= filter_var($id_rol,FILTER_VALIDATE_INT);
        $autorizacion= filter_var($autorizado,FILTER_VALIDATE_INT);
        
        $sql="INSERT INTO roles_temporales (id,id_rol,id_usuario,autorizado,fecha_registro,estado) VALUES($Id,$id_rol,$id_usuario,$autorizacion,NOW(),1)";
        if($this->db->query($sql))
        {
            return $this->db->insert_id;
        }
        else{
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function CambiarEstadoRolTemporal($Id,$estado)
    {
        $id = filter_var($Id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "UPDATE roles_temporales SET estado = $estado WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function InsertarDetalleUsuario($id_usuario, $contraseña_actual)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($usuario = "detalle_usuario");
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $contrasena = $this->db->real_escape_string($contraseña_actual);
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO detalle_usuario (id,id_usuario,contraseña,fecha,estado) 
        VALUES($id,'$id_usuario','$hash',NOW(),1)";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarDetalleUsuario($id, $contraseña)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $contraseña = $this->db->real_escape_string($contraseña);
        $estado = 1;
        $sql = "UPDATE detalle_usuario SET contraseña='$contraseña' , estado = $estado WHERE id_usuario='$id'";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoContraseña($Id, $estado)
    {
        $id = filter_var($Id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "UPDATE detalle_usuario SET estado = $estado WHERE id_usuario=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    /**
     * Privilegios rol
     */
    public function MostrarRolModulos()
    {
        $sql = "SELECT us.usuario AS autorizado, u.nombre AS grupo, u.id AS id_usuario,u.nombre,GROUP_CONCAT(CONCAT(m.nombre, ' - ', sm.nombre) ORDER BY m.nombre SEPARATOR ', ') AS usuario_modulos_submodulos, u.estado AS rol_estado,   
        COUNT(DISTINCT sm.id_modulo) AS cantidad_modulos_asignados
        FROM privilegio_rol pu 
        JOIN sub_modulo sm ON sm.id = pu.id_sub_modulo 
        LEFT JOIN modulo m ON sm.id_modulo = m.id 
        JOIN rol u ON u.id = pu.id_usuario
        LEFT JOIN usuario us ON us.id=pu.autorizacion
        GROUP BY u.nombre";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->privilegios[] = $row;
                }
                return $this->privilegios;
            } else {
                return null; // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function MostrarModulos()
    {
        $query = "SELECT m.id AS modulo_id, m.nombre AS modulo_nombre, 
                sm.id AS submodulo_id, sm.nombre AS submodulo_nombre
            FROM modulo m LEFT JOIN sub_modulo sm ON m.id = sm.id_modulo";

        $result = $this->db->query($query);
        $modulos = array();
        while ($row = $result->fetch_assoc()) {
            $modulo_id = $row['modulo_id'];
            $submodulo_id = $row['submodulo_id'];
            if (!isset($modulos[$modulo_id])) {
                $modulos[$modulo_id] = array(
                    'id' => $modulo_id,
                    'nombre' => $row['modulo_nombre'],
                    'submodulos' => array()
                );
            }
            if (!empty($submodulo_id)) {
                $submodulo = array(
                    'id' => $submodulo_id,
                    'nombre' => $row['submodulo_nombre']
                );
                $modulos[$modulo_id]['submodulos'][] = $submodulo;
            }
        }
        return array_values($modulos);
    }
    public function ObtenerPrivilegiosFaltantes($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $query = "SELECT m.id AS modulo_id, m.nombre AS modulo_nombre, 
                        sm.id AS submodulo_id, sm.nombre AS submodulo_nombre
            FROM modulo m 
            LEFT JOIN sub_modulo sm ON m.id = sm.id_modulo
            WHERE sm.id NOT IN (SELECT pu.id_sub_modulo FROM privilegio_rol pu WHERE 
                    pu.id_usuario = '$Id')";

        $result = $this->db->query($query);
        $modulos = array();
        while ($row = $result->fetch_assoc()) {
            $modulo_id = $row['modulo_id'];
            $submodulo_id = $row['submodulo_id'];
            if (!isset($modulos[$modulo_id])) {
                $modulos[$modulo_id] = array(
                    'id' => $modulo_id,
                    'nombre' => $row['modulo_nombre'],
                    'submodulos' => array()
                );
            }
            if (!empty($submodulo_id)) {
                $submodulo = array(
                    'id' => $submodulo_id,
                    'nombre' => $row['submodulo_nombre']
                );
                $modulos[$modulo_id]['submodulos'][] = $submodulo;
            }
        }
        return array_values($modulos);
    }
    public function MostrarTodosLosPrivilegios($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);

        $query = "SELECT 
        pu.id AS privilegio_id,
        m.id AS modulo_id,
        m.nombre AS modulo_nombre,
        sm.id AS submodulo_id,
        sm.nombre AS submodulo_nombre
        FROM 
        privilegio_rol pu
        INNER JOIN 
        sub_modulo sm ON pu.id_sub_modulo = sm.id
        LEFT JOIN 
        modulo m ON sm.id_modulo = m.id
        WHERE 
        pu.id_usuario = $Id
        ORDER BY
        privilegio_id, modulo_id, submodulo_id";
        $result = $this->db->query($query);
        $modulos = array();
        while ($row = $result->fetch_assoc()) {
            $modulo_id = $row['modulo_id'];
            $submodulo_id = $row['privilegio_id'];
            if (!isset($modulos[$modulo_id])) {
                $modulos[$modulo_id] = array(
                    'id' => $modulo_id,
                    'nombre' => $row['modulo_nombre'],
                    'submodulos' => array()
                );
            }
            if (!empty($submodulo_id)) {
                $submodulo = array(
                    'id' => $submodulo_id,
                    'nombre' => $row['submodulo_nombre']
                );
                $modulos[$modulo_id]['submodulos'][] = $submodulo;
            }
        }
        return array_values($modulos);
    }
    public function InsertarPrivilegioRol($id_sub_modulo, $id_usuario, $autorizacion)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($usuario = "privilegio_rol");
        $id_sub_modulo = filter_var($id_sub_modulo, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $autorizacion = filter_var($autorizacion, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO privilegio_rol (id,id_sub_modulo,id_usuario,autorizacion) 
        VALUES($id,'$id_sub_modulo','$id_usuario','$autorizacion')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarPrivilegioRol($id, $id_sub_modulo, $id_usuario, $autorizacion)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        // $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $id_sub_modulo = filter_var($id_sub_modulo, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $autorizacion = filter_var($autorizacion, FILTER_VALIDATE_INT);

        $sql = "UPDATE privilegio_rol SET id_sub_modulo='$id_sub_modulo', id_usuario='$id_usuario',  autorizacion='$autorizacion' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function EliminarPrivilegiosRol($Id)
    {
        $Id = filter_var($Id, FILTER_VALIDATE_INT);
        $Sql = "DELETE FROM privilegio_rol WHERE id = $Id";
        if ($this->db->query($Sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    /**
     * Permisos Rol
     */
    public function InsertarPrivilegioPermisoRol($id_permiso, $id_usuario, $autorizacion)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($usuario = "privilegio_permiso_rol");
        $id_permiso = filter_var($id_permiso, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $autorizacion = filter_var($autorizacion, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO privilegio_permiso_rol (id,id_permiso,id_usuario,autorizacion) 
        VALUES($id,'$id_permiso','$id_usuario','$autorizacion')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarPrivilegioPermisoRol($id, $id_permiso, $id_usuario, $autorizacion)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_permiso = filter_var($id_permiso, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $autorizacion = filter_var($autorizacion, FILTER_VALIDATE_INT);

        $sql = "UPDATE privilegio_permiso_rol SET id_permiso='$id_permiso', id_usuario='$id_usuario',  autorizacion='$autorizacion' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    /**
     * Conexion
     */
    public function MostrarConexion()
    {
        $sql = "SELECT c.*,u.id AS idUsuario,u.usuario,r.nombre AS rol FROM conexion c
         INNER JOIN usuario u ON u.id = c.id_usuario
         INNER JOIN rol  r ON r.id =u.id_rol
         INNER JOIN perfil p On p.id=r.id_perfil
         WHERE c.estado = 1 AND r.id_perfil != 2";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $this->conexion[] = $row;
            }
            return $this->conexion;
        } else {
            return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
        }
    }
    public function InsertarConexion($id_usuario, $mac, $ip, $navegador, $version_navegador, $dispositivo, $version_dispositivo, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($usuario = "conexion");
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $mac = $this->db->real_escape_string($mac);
        $ip = $this->db->real_escape_string($ip);
        $navegador = $this->db->real_escape_string($navegador);
        $version_navegador = $this->db->real_escape_string($version_navegador);
        $dispositivo = $this->db->real_escape_string($dispositivo);
        $version_dispositivo = $this->db->real_escape_string($version_dispositivo);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO conexion(id,id_usuario,mac,ip,navegador,version_navegador,dispositivo,version_dispositivo,fecha_ingreso,estado)
        VALUES($id,'$id_usuario','$mac','$ip','$navegador','$version_navegador','$dispositivo','$version_dispositivo', NOW(),'$estado'
        )";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function CambiarEstadoConexion($id, $estado)
    {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE conexion SET estado = $estado WHERE id_usuario = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    /**
     * Bloqueo de sessiones
     */
    public function InsertarBloqueoUsuario($id_usuario, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($bloqusuario = "bloqueo_usuario");
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "INSERT INTO `bloqueo_usuario`(`id`, `id_usuario`, `descripcion`, `estado`) VALUES ($id,'$id_usuario','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarBloqueoUsuario($id, $id_usuario, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE `bloqueo_usuario` SET `id_usuario`='$id_usuario',`descripcion`='$descripcion',`estado`='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function CambiarEstadoBloqueoUsuario($id, $estado)
    {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE  SET estado = $estado WHERE id = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }
    /**
     * Historial de sesiones
     */

    public function InsertarHistorialSesion($id_usuario, $ip, $accion, $descripcion)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($bloqusuario = "historial_de_sesion");
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $ip = $this->db->real_escape_string($ip);
        $accion = $this->db->real_escape_string($accion);
        $descripcion = $this->db->real_escape_string($descripcion);

        $sql = "INSERT INTO `historial_de_sesion`(`id`, `id_usuario`, `ip`, `accion`, `descripcion`, `fecha`) 
        VALUES ($id,'$id_usuario','$ip','$accion','$descripcion',NOW())";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    /**
     * Enviar correos
     */
    /**
     * Correos Institucionales
     */
    public function enviar_correos($correo, $nombre, $apellido, $usuario, $codigo)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ingsoftwar123@gmail.com';
            $mail->Password   = 'xishvjfvtnrabdpj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom($correo, 'Tienda de ropa $EBRAS$');
            $mail->addAddress($correo, $nombre);
            $mail->isHTML(true);

            // Corregir caracteres especiales
            $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8');
            $codigo = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
            $mail->Subject = 'Verificacion de cuenta';
            $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Verificación de cuenta</title>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <style type=\"text/css\">
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    color: #444444;
                    line-height: 1.6;
                    margin: 0;
                }
        
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #e1e1e1;
                    background-color: #ffffff;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                }
        
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .logo img {
                    max-width: 200px;
                }
        
                h1 {
                    text-align: center;
                    color: #007bff;
                    margin-bottom: 20px;
                }
        
                p {
                    margin-bottom: 10px;
                }
        
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #161a39;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 4px;
                }
        
                .button:hover {
                    background-color: #000000;
                }
        
                .verification-code {
                    background-color: #f9f9f9;
                    border: 1px solid #cccccc;
                    padding: 10px;
                    margin-bottom: 20px;
                    font-size: 16px;
                    color: #161a39;
                }
                </style>
            </head>
            <body>
                <div class=\"container\">
                    <div class=\"logo\">
                        <img src='https://res.cloudinary.com/dxhb03y8f/image/upload/v1700035327/h8861tbge5llnulsl6zd.png' alt='Logo del sitio'>
                    </div>
                    <h1>Acceso</h1>
                    <p>Estimad@ <span style=\"color: #ff7f50;\">$nombre $apellido</span>,</p>
                    <p>Queremos informarte que tu cuenta de acceso ha sido creada. A continuación, te proporcionamos los detalles de tu cuenta:</p>
                    <div class=\"verification-code\">
                        <strong style=\"color: #161a39;\">Correo Electronico:</strong> $usuario
                    </div>
                    <div class=\"verification-code\">
                    <strong style=\"color: #161a39;\">Contraseña:</strong> $codigo
                     </div>
                    <p>Por favor, asegurate de guardar esta informacion de manera segura y no compartirla con nadie mas. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
                    <p>Te damos la bienvenida y esperamos que tengas una experiencia productiva y positiva en nuestra plataforma.

                    Saludos cordiales.</p>
        
                </div>
            </body>
            </html>";

            $mail->send();
        } catch (Exception $e) {
        }
    }

    /**
     * Correo de cambios de contraseñas
     */
    /**
     * Correos de validacion de clientes
     */
    public function EnviarCodigoVerificacion($correo, $nombre, $apellido, $codigo)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ingsoftwar123@gmail.com';
            $mail->Password   = 'xishvjfvtnrabdpj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->setFrom('ingsoftwar123@gmail.com', 'Tienda $EBRAS$');
            $mail->addAddress($correo, $nombre);
            $mail->isHTML(true);
            // Corregir caracteres especiales
            $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8');
            $codigo = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
            $mail->Subject = 'Verificacion de cuenta';
            $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Verificación de cuenta</title>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <style type=\"text/css\">
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    color: #444444;
                    line-height: 1.6;
                    margin: 0;
                }
        
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #e1e1e1;
                    background-color: #ffffff;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                }
        
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .logo img {
                    max-width: 200px;
                }
        
                h1 {
                    text-align: center;
                    color: #007bff;
                    margin-bottom: 20px;
                }
        
                p {
                    margin-bottom: 10px;
                }
        
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #161a39;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 4px;
                }
        
                .button:hover {
                    background-color: #000000;
                }
        
                .verification-code {
                    background-color: #f9f9f9;
                    border: 1px solid #cccccc;
                    padding: 10px;
                    margin-bottom: 20px;
                    font-size: 16px;
                    color: #161a39;
                }
                </style>
            </head>
            <body>
                <div class=\"container\">
                    <div class=\"logo\">
                        <img src='https://res.cloudinary.com/dxhb03y8f/image/upload/v1700035327/h8861tbge5llnulsl6zd.png' alt='Logo del sitio'>
                    </div>
                    <h1>¡Verifica tu cuenta!</h1>
                    <p>Estimado <span style=\"color: #ff7f50;\">$nombre $apellido</span>,</p>
                    <p>Gracias por registrarte en nuestro sitio web. Para activar tu cuenta, por favor copia este codigo en la seccion de verificacion de cuenta:</p>
                    <div class=\"verification-code\">
                        <strong style=\"color: #161a39;\">Codigo de verificacion:</strong> $codigo
                    </div>
                    <p>Una vez que hayas verificado tu cuenta, podras acceder a todas las funcionalidades de nuestro sitio.</p>
                    <p>Si no has creado una cuenta en nuestro sitio, por favor ignora este correo electronico.</p>
                    <p>¡Gracias y bienvenido/a!</p>
                </div>
            </body>
            </html>";

            $mail->send();
        } catch (Exception $e) {
        }
    }
    /**
     * Enviar correo desde el front para contacto
     */

    public function EnviarCorreo($correo, $nombre, $mensaje, $empresa, $asunto)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();

            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            //    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Username   = 'ingsoftwar123@gmail.com';
            $mail->Password   = 'xishvjfvtnrabdpj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            // Configuración del correo
            $mail->setFrom($correo, $nombre);
            $mail->addAddress('ingsoftwar123@gmail.com'); // Dirección de destino
            $mail->Subject = $asunto;
            $mail->isHTML(true);
            // Corregir caracteres especiales
            $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

            $mail->Subject = $asunto;
            $mail->Body = "<!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>Verificación de cuenta</title>
                <!-- Agrega el enlace a Bootstrap CDN -->
                <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" rel=\"stylesheet\">
                <style type=\"text/css\">
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9;
                        color: #444444;
                        line-height: 1.6;
                        margin: 0;
                    }
            
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #e1e1e1;
                        background-color: #ffffff;
                        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    }
            
                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }
            
                    .logo img {
                        max-width: 200px;
                    }
            
                    h1 {
                        text-align: center;
                        color: #007bff;
                        margin-bottom: 20px;
                    }
            
                    p {
                        margin-bottom: 10px;
                    }
            
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #161a39;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 4px;
                    }
            
                    .button:hover {
                        background-color: #000000;
                    }
            
                    .verification-code {
                        background-color: #f9f9f9;
                        border: 1px solid #cccccc;
                        padding: 10px;
                        margin-bottom: 20px;
                        font-size: 16px;
                        color: #161a39;
                    }
                </style>
            </head>
            <body>
                <div class=\"container\">
                    <div class=\"logo\">
                        <img src=\"https://res.cloudinary.com/dxhb03y8f/image/upload/v1694401173/ixppsjhs9dzbt2jxwtea.png\" alt='Logo del sitio' class=\"img-fluid\">
                    </div>
                    <h1>¡Mensaje!</h1>
                    <p>Estimado <span style=\"color: #ff7f50;\">$nombre</span>,</p>
                    <p>Empresa = $empresa</p>
                    <p>Correo = $correo</p>
                    <div class=\"verification-code\">
                        <strong style=\"color: #161a39;\">Mensaje del cliente:</strong> $mensaje
                    </div>
                  
                </div>
                <!-- Agrega el script de Bootstrap al final del documento -->
                <script src=\"https://code.jquery.com/jquery-3.2.1.slim.min.js\"></script>
                <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js\"></script>
                <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js\"></script>
            </body>
            </html>
            ";

            $mail->send();
        } catch (Exception $e) {
            return $e;
        }
    }
}
