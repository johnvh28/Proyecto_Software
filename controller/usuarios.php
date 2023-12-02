<?php
class UsuarioController
{
    public function __construct()
    {
        require_once "model/usuarios.php";
    }

    /**
     * Roles
     */
    public function rol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Rol = new Usuarios_Model();
            $Roles['rol'] = $Rol->MostrarRol();
            require_once 'view/Gestion_usuarios/Rol/rol.php';
        }
    }
    public function CrearRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Rol = new Usuarios_Model();
            $Roles["perfil"] = $Rol->Perfil();
            require_once "view/Gestion_usuarios/Rol/CrearRol.php";
        }
    }

    public function GuardarRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $perfil = $_POST['perfil'];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $estado = $_POST["estado"];
            $Rol = new Usuarios_Model();
            $Rol->InsertarRol($perfil, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado correctamente el rol";
            header("Location:index.php?c=usuario&a=rol");
        }
    }

    public function ActualizarRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Rol = new Usuarios_Model();
            $Id = $_GET["id"];
            $Roles['roles'] = $Rol->ObtenerRolId($Id);
            $Roless["perfil"] = $Rol->Perfil();
            require_once "view/Gestion_usuarios/Rol/ActualizarRol.php";
        }
    }
    public function ActualizacionRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Id = $_POST['id'];
            $perfil = $_POST['perfil'];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $estado = $_POST["estado"];
            $Rol = new Usuarios_Model();
            $Rol->ActualizarRol($Id, $perfil, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado correctamente el rol";
            header("Location:index.php?c=usuario&a=rol");
        }
    }

    public function EliminarRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Id = $_POST["id"];
            $estado = 2;
            $Rol = new Usuarios_Model();
            $Rol->CambiarEstadoRol($Id, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado correctamente el rol";
            header("Location:index.php?c=usuario&a=rol");
        }
    }
    /**
     * Usuarios
     */
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Usuarios['usuarios'] = $Usuario->MostrarUsuarios();
            require_once 'view/Gestion_usuarios/Usuarios/Usuarios.php';
        }
    }
    public function CrearUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuarios = new Usuarios_Model();

            $Roles['roles'] = $Usuarios->Roles();
            $Empleado['empleados'] = $Usuarios->MostrarTrabajadorSinUsuario();
            require_once "view/Gestion_usuarios/Usuarios/CrearUsuarios.php";
        }
    }
    public function UpdateUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuarios = new Usuarios_Model();
            $Id = $_GET['id'];
            $Roles['roles'] = $Usuarios->Roles();
            $usuario['usuario'] = $Usuarios->ObtenerUsuarioId($Id);
            $Empleado['empleado'] = $Usuarios->ObtenerNombreEmpleado($Id);
            require_once "view/Gestion_usuarios/Usuarios/Actualizar.php";
        }
    }
    public function PrivilegiosUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuarios = new Usuarios_Model();
            $Id = $_GET['id'];
            $Roles['roles'] = $Usuarios->RolesSinUsuario($Id);
            $historico['historico'] = $Usuarios->ObtenerRolesHistoricos($Id);
            $Empleado['empleado'] = $Usuarios->ObtenerNombreEmpleado($Id);
            require_once "view/Gestion_usuarios/Usuarios/Privilegios.php";
        }
    }
    public function GuardarUsuario()
    {
        $usuario = new Usuarios_Model();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_trabajador = $_POST['id_empleado'];
            $Rol = $_POST['rol'];
            $estado = $_POST['estado'];
            //Validar el id de la persona
            $id = $usuario->getIdpersona($id_trabajador);
            $persona = $usuario->obtener_datos($id);
            $correo = $usuario->generar_usuarios($persona["nombre"], $persona["apellido"]);
            $contraseña = $usuario->generar_contraseña($longitud = 8);
            $usuario->enviar_correos($persona["correo"], $persona["nombre"], $persona["apellido"], $correo, $contraseña);
            $resultado = $usuario->InsertarUsuario($Rol, $id, $correo, $estado);
            $usuario->InsertarDetalleUsuario($resultado['Id'], $contraseña);
            if ($resultado) {
                session_start();
                $_SESSION['tipo'] = "success";
                $_SESSION['mensaje'] = "Se ha guardado correctamente el usuario e enviado su credenciales a su correo";
                header("location: index.php?c=usuario");
            } else {
                // Mostrar mensaje de error.
                header("location: index.php?c=usuarios&a=crear");
            }
            return $resultado;
        }
    }

    public function ActualizarUsuario()
    {
        $usuario = new Usuarios_Model();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $Id = $_POST['id'];
            $rol = $_POST['rol'];
            $estado = $_POST['estado'];
            $usuario->ActualizarUsuario($Id, $rol, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha actualizado correctamente el usuario";
            header("Location:index.php?c=usuario");
        }
    }
    public function verificar()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Usuarios['usuarios'] = $Usuario->MostrarUsuariosSinVerificar();
            require_once 'view/Gestion_usuarios/Verificar/VerificarUsuario.php';
        }
    }
    public function EstadoUsuarios()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Usuario = new Usuarios_Model();
            $Id = $_POST["id"];
            $estado = $_GET['estado'];
            $Usuario = $Usuario->CambiarEstadoUsuario($Id, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha activado correctamente el usuario";
            header("location: index.php?c=usuario");
        }
    }
    public function InsertarPrivilegio()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Usuario = new Usuarios_Model();
            $Id = $_POST["Id"];
            $Id_rol=$_POST['rol'];
            $autorizado=$_POST['autorizado'];
            $Usuario->InsertarRolesTemporales($Id_rol,$Id,$autorizado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha asignado el rol temporal";
            header("location: index.php?c=usuario&a=PrivilegiosUsuario&id=".$Id);
        }
    }
    public function EliminarRoles()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Id=$_GET['id'];
            $usuario=$_GET['usuario'];
            $Estado=$_GET['estado'];
            $Usuario = new Usuarios_Model();
            $Usuario ->CambiarEstadoRolTemporal($Id,$Estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha asignado el rol temporal";
            header("location: index.php?c=usuario&a=PrivilegiosUsuario&id=". $usuario);
        }
    }
    /**
     * Modulos privilegios rol
     */
    public function modulos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Usuarios['usuarios'] = $Usuario->MostrarRolModulos();
            require_once 'view/Gestion_usuarios/Modulos/Modulos.php';
        }
    }
    public function AsignarModulos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Roles['roles'] = $Usuario->Roless();
            $data["modulos"] = $Usuario->MostrarModulos();
            require_once 'view/Gestion_usuarios/Modulos/AsignarModulos.php';
        }
    }
    public function actualizarprivilegios()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Id = $_GET['id'];
            $Roles['roles'] = $Usuario->Roles();
            $data["modulos"] = $Usuario->ObtenerPrivilegiosFaltantes($Id);
            require_once 'view/Gestion_usuarios/Modulos/ActualizarModulos.php';
        }
    }
    public function eliminarprivilegios()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Id = $_GET['id'];
            $Roles['roles'] = $Usuario->Roles();
            $data["modulos"] = $Usuario->MostrarTodosLosPrivilegios($Id);
            require_once 'view/Gestion_usuarios/Modulos/EliminarPrivilegios.php';
        }
    }
    public function GuardarPrivilegio()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Usuario = new Usuarios_Model();
            $Rol = $_POST["rol"];
            $submodulo = $_POST['submodulos'];
            $autorizado=$_POST['autorizado'];
            foreach ($submodulo as $moduloId => $submoduloIds) {
                foreach ($submoduloIds as $id_submodulo) {
                    $Usuario->InsertarPrivilegioRol($id_submodulo, $Rol, $autorizado);
                }
            }
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha registrados los privilegios de manera exitosa";
            header("location: index.php?c=usuario&a=modulos");
        }
    }
    public function EliminarPrivilegio()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Usuario = new Usuarios_Model();
            $Rol = $_POST["rol"];
            $submodulos = $_POST['submodulos'];
            foreach ($submodulos as $moduloId => $submoduloIds) {
              
                foreach ($submoduloIds as $id_submodulo) {
                
                    $Usuario->EliminarPrivilegiosRol($id_submodulo);
                }
            }
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION['mensaje'] = "Se ha desactivado los privilegios de manera exitosa";
            header("location: index.php?c=usuario&a=modulos");
        }
    }
    
    /**
     * Monitoreo
     */
    public function  monitoreo()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Usuario = new Usuarios_Model();
            $Usuarios['usuarios'] = $Usuario->MostrarConexion();
            require_once 'view/Gestion_usuarios/Monitoreo/MonitoreoUsuario.php';
        }
    }
}
