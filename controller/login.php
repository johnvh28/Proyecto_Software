<?php
class LoginController
{
    public function __construct()
    {
        require_once "model/usuarios.php";
        require_once "model/login.php";
    }

    public function validarLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
        session_start();
        $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
        $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

        $ip = $_SERVER['REMOTE_ADDR'];
        $direccionMAC = strtok(exec('getmac'), ' ');

        $loginModel = new Login_Model();
        $conexion = $loginModel->obtenerInformacionNavegador();

        $navegador = $conexion['navegador'];
        $versionNavegador = $conexion['version_navegador'];
        $sistemaOperativo = $conexion['os'];
        $versionSistemaOperativo = $conexion['version_os'];

        if ($id = $loginModel->validarUsuarios($usuario)) {
            if ($loginModel->validarContraseña($id, $contraseña)) {
                $idPerfil = $loginModel->validarPerfil($id);
                $usuarioModel = new Usuarios_Model();
                if ($idPerfil != 2) {
                    
                    $_SESSION['privilegios'] = $loginModel->ObtenerPrivilegio($id);
                    $_SESSION['privilegiosTemporales'] = $loginModel->ObtenerPrivilegioTemporales($id);
                    $_SESSION['IdUsuario'] = $id;
                    $usuarioModel->insertarConexion($id, $direccionMAC, $ip, $navegador, $versionNavegador, $sistemaOperativo, $versionSistemaOperativo, 1);
                    $nombres = $loginModel->datosUsuarios($id);
                    $_SESSION['nombre'] = $nombres['Nombre'];
                    $_SESSION['apellido'] = $nombres['Apellido'];
                    $_SESSION['foto'] = $nombres['Foto'];
                    $_SESSION['codigo'] = $nombres['Codigo'];
                    $_SESSION['IdEmpleado'] = $nombres['IdEmpleado'];
                    $_SESSION['verificar'] = $idPerfil;
                    header("Location: index.php?c=page&a=inicio");
                } else {
                    $usuarioModel->insertarConexion($id, $direccionMAC, $ip, $navegador, $versionNavegador, $sistemaOperativo, $versionSistemaOperativo, 1);
                    $nombres = $loginModel->datosUsuariosclientes($id);
                    $_SESSION['IdUsuario'] = $id;
                    $_SESSION['nombre'] = $nombres['Nombre'];
                    $_SESSION['apellido'] = $nombres['Apellido'];
                    $_SESSION['foto'] = $nombres['Foto'];
                    $_SESSION['verificar'] = $idPerfil;
                    $_SESSION['tipo'] = "success";
                    $_SESSION["mensaje"] = "Se ha registrado con éxito";
                    header("Location: index.php?c=page");
                }
            } else {
                $_SESSION['tipo'] = "error";
                $_SESSION["mensaje"] = "Usuario o contraseña incorrecta, verifique los datos";
                header("Location: index.php?c=page");
            }
        } else {
            $_SESSION['tipo'] = "error";
            $_SESSION["mensaje"] = "No se encontró el usuario en la base de datos";
            header("Location: index.php?c=page");
        }
    }

    public function cerrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            session_start();
    
            if (isset($_GET['id'], $_SESSION['IdUsuario']) && $_GET['id'] == $_SESSION['IdUsuario']) {
                $IdUsuario = $_GET['id'];
                $estado = 2;
                // Destruir la sesión
                session_unset();
                session_destroy();
                $Usuario = new Usuarios_Model();
                $Usuario->cambiarEstadoConexion($IdUsuario, $estado);
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha cerrado la sesión correctamente";
                header("Location: index.php?c=page");
               // exit(); // Asegura que no se ejecuten más acciones después de la redirección
            }
        }
    }
    public function cerrars()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            echo $_SESSION['IdUsuario'];
            if ($_POST['id'] == $_SESSION['IdUsuario']) {
                echo $_SESSION['IdUsuario'];
                $IdUsuario = $_POST['id'];
                $estado = 2;
                // Destruir la sesión
                session_unset();
                session_destroy();
                $Usuario = new Usuarios_Model();
                $Usuario->cambiarEstadoConexion($IdUsuario, $estado);
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha cerrado la sesión correctamente";
                  header("Location: index.php?c=page");
               // exit(); // Asegura que no se ejecuten más acciones después de la redirección
            }
        }
    }
}
