<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Psr7\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;

class PageController
{
    public function __construct()
    {
        require_once "model/login.php";
        require_once "model/usuarios.php";
        require_once "model/productos.php";
        require_once "model/gestion_venta.php";
    }

    public function index()
    {
        $Productos = new Productos_Model();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
        $productos['camisas'] = $Productos->MostrarProductosPagina();
        require_once "view/page/index.php";
    }

    public function inicio()
    {

        require_once "view/inicio/inicio.php";
    }
    public function contacto()
    {
        $Productos = new Productos_Model();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();

        require_once "view/page/Contacto/Conctato.php";
    }

    public function productos()
    {
        $Productos = new Productos_Model();
        $productos['camisas'] = $Productos->MostrarProductosPagina();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
        $color['color'] = $Productos->selectcolor();
        $talla['talla'] = $Productos->selectmodelo();
        $manga['manga'] = $Productos->selectmanga();
        $modelo['modelo'] = $Productos->selectmodelo();
        require_once "view/page/Productos/Productos.php";
    }
    public function carrito()
    {
        session_start();
        if (isset($_SESSION['nombre'])) {
            $Productos = new Productos_Model();
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            require_once "view/page/Carrito/Carrito.php";
        } else {
            header("Location:index.php?c=page");
        }
    }
    public function checkout()
    {
        session_start();
        if (isset($_SESSION['nombre'])) {
            $Productos = new Productos_Model();
            $Selects = new Persona_model();
            $Municipios['Municipios'] = $Selects->ObtenerDepartamentosConMunicipios();
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            $direccion['direccion'] = $Selects->DireccionCliente($_SESSION['IdPersona']);
            require_once "view/page/Checkout/Checkout.php";
        } else {
            header("Location:index.php?c=page");
        }
    }
    public function pedido()
    {
        session_start();
        $Venta = new Venta_Model();
        $IdCliente = $_SESSION['IdCliente'];
        $total = $this->calcularTotalCarrito($_SESSION['carrito']);
        $IdVenta = $Venta->InsertarPedido($IdCliente, $total, 0, $total, 1);
     
        foreach ($_SESSION['carrito'] as $producto) {
            $Venta->InsertarDetallePedido($IdVenta, $producto['id'], $producto['cantidad'], $producto['precio']);
        }
        // Check if the 'flexRadioDefault' key is set in the $_POST array
        if (isset($_POST['flexRadioDefault'])) {
            $selectedOption = $_POST['flexRadioDefault'];
            if ($selectedOption === "Entrega local") {
            } else {
                $municipio = $_POST['municipio'];
                $punto=$_POST['punto'];
                $direccion=$_POST['direccion'];
                $Selects = new Persona_model();
                $IdDireccion=$Selects->InsertarPuntoReferencia($punto,$direccion,$municipio);
                $Venta->InsertarDireccionPedido($IdDireccion,$IdVenta,1);
            }
        }
        unset($_SESSION['carrito']);
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha realizado el pedido correctamente";
        header("Location:index.php?c=page");
    }
    public function calcularTotalCarrito($carrito)
    {
        $total = 0;
        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        return $total;
    }
    public function blog()
    {
        $Productos = new Productos_Model();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
    }
    public function cambiocontraseña()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Usuario = new Usuarios_Model();
            $loginModel = new Login_Model();
            $Id = $_POST['id'];

            $Contraseña = $_POST['contraseña_nueva'];
            $Usuario->CambiarEstadoContraseña($Id, 2);

            $Usuario->InsertarDetalleUsuario($Id, $Contraseña);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha cambiado con éxito la contraseña";
            header("Location:index.php?c=page&a=inicio");
        }
    }
    public function EnviarCorreo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombre"];
            $email = $_POST["correo"];
            $asunto = $_POST["asunto"];
            $empresa = $_POST["empresa"];
            $mensaje = $_POST["mensaje"];
            $Correo = new Usuarios_Model();
            $resultado = $Correo->EnviarCorreo($email, $nombre, $mensaje, $empresa, $asunto);
            session_start();
            $_SESSION["tipo"] = "success";
            $_SESSION["mensaje"] = "Se ha enviado correctamente el correo";
            header("Location:index.php?c=page&a=contacto");
        }
    }
    public function registro()
    {
        $Productos = new Productos_Model();

        $Selects = new Persona_model();

        $Genero['Generos'] = $Selects->SelectGenero();
        $Municipios['Municipios'] = $Selects->ObtenerDepartamentosConMunicipios();
        $Pais['paises'] = $Selects->pais();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
        require_once "view/page/Auth/RegistroClienteNatural.php";
    }
    public function GuardarCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Colaborador = new Venta_Model();
            $persona = new Persona_model();
            /** Atributos personas */
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];

            $foto = $this->SubirImagen($_FILES['foto']);
            $municipio = $_POST['municipio'];
            $direccion = $_POST['direccion'];
            $IdLocalidad = $persona->InsertarPuntoReferencia($nombre, $direccion, $municipio);

            $IdPersona = $persona->InsertarPersona($nombre, $telefono, $IdLocalidad, $correo, $foto);
            /**Atributos Persona Natural*/
            $apellido = $_POST['apellido'];
            $id_genero = $_POST['genero'];
            $nacionalidad = $_POST['nacionalidad'];
            $tipoidentificacion = $_POST['tipo_identificacion'];
            $identificacion = $_POST['identificacion'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $persona->InsertarPersonaNatural($IdPersona, $nacionalidad, $id_genero, $apellido, $tipoidentificacion, $identificacion, $fecha_nacimiento);
            /** Atributos colaborador */

            $Colaborador->InsertarCliente($IdPersona, $tipo = "Normal", 1);
            $usuario = new Usuarios_Model();
            $Usuarios = $usuario->InsertarUsuario(2, $IdPersona, $correo, 0);
            $usuario->EnviarCodigoVerificacion($correo, $nombre, $apellido, $Usuarios['Codigo']);
            $usuario->InsertarDetalleUsuario($Usuarios['Id'], $contraseña);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha enviado un codigo de verficacion";
            header("Location:index.php?c=page&a=verificacion&cliente=" . $correo);
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function verificacion()
    {
        $Productos = new Productos_Model();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
        require_once "view/page/Auth/verficacionClientes.php";
    }
    public function VerificarUsuario()
    {
        session_start();
        $correo = $_POST['correo'];
        $codigo = $_POST['codigo'];
        $usuario = new Usuarios_Model();
        $verificar = $usuario->verificacion($correo, $codigo);

        if (!$verificar) {
            $error = "El código de verificación es incorrecto. Por favor, inténtalo nuevamente.";

            $_SESSION["tipo"] =  "error";
            $_SESSION['mensaje'] = $error;
            header("Location: index.php?c=page&a=verificacion&cliente=$correo");
        } else {
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha verificado correctamente";
            header("Location: index.php?c=page");
        }
    }
    public function eliminarProductoCarrito()
    {
        if (isset($_GET['id'])) {
            session_start();
            $productoId = $_GET['id'];

            if (isset($_SESSION['carrito'][$productoId])) {
                // Eliminar el producto del carrito
                unset($_SESSION['carrito'][$productoId]);
            }

            // Redireccionar a la página del carrito o donde desees después de eliminar
            header("Location: index.php?c=page&a=productos");
        }
    }
    public function eliminarProductoCarritos()
    {
        if (isset($_GET['id'])) {
            session_start();
            $productoId = $_GET['id'];

            if (isset($_SESSION['carrito'][$productoId])) {
                // Eliminar el producto del carrito
                unset($_SESSION['carrito'][$productoId]);
            }

            // Redireccionar a la página del carrito o donde desees después de eliminar
            header("Location: index.php?c=page&a=carrito");
        }
    }
    public function filtros()
    {
        if (isset($_GET['id'])) {
            $Id = $_GET['id'];
            $Productos = new Productos_Model();
            $productos['camisas'] = $Productos->MostrarProductossubcategorias($Id);
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            $color['color'] = $Productos->selectcolor();
            $talla['talla'] = $Productos->selectmodelo();
            $manga['manga'] = $Productos->selectmanga();
            $modelo['modelo'] = $Productos->selectmodelo();
            require_once "view/page/Productos/Productos.php";
        }
    }
    public function mangas()
    {
        if (isset($_GET['id'])) {
            $Id = $_GET['id'];
            $Productos = new Productos_Model();
            $productos['camisas'] = $Productos->MostrarProductosMangas($Id);
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            $color['color'] = $Productos->selectcolor();
            $talla['talla'] = $Productos->selectmodelo();
            $manga['manga'] = $Productos->selectmanga();
            $modelo['modelo'] = $Productos->selectmodelo();
            require_once "view/page/Productos/Productos.php";
        }
    }
    public function colores()
    {
        if (isset($_GET['id'])) {
            $Id = $_GET['id'];
            $Productos = new Productos_Model();
            $productos['camisas'] = $Productos->MostrarProductosColores($Id);
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            $color['color'] = $Productos->selectcolor();
            $talla['talla'] = $Productos->selectmodelo();
            $manga['manga'] = $Productos->selectmanga();
            $modelo['modelo'] = $Productos->selectmodelo();
            require_once "view/page/Productos/Productos.php";
        }
    }
    public function modelos()
    {
        if (isset($_GET['id'])) {
            $Id = $_GET['id'];
            $Productos = new Productos_Model();
            $productos['camisas'] = $Productos->MostrarProductosColores($Id);
            $Categorias['productos'] = $Productos->CategoriasSubcategorias();
            $color['color'] = $Productos->selectcolor();
            $talla['talla'] = $Productos->selectmodelo();
            $manga['manga'] = $Productos->selectmanga();
            $modelo['modelo'] = $Productos->selectmodelo();
            require_once "view/page/Productos/Productos.php";
        }
    }

    public function carritos()
    {
        if (isset($_GET['id'])) {
            session_start();
            $productoId = $_GET['id'];
            $Productos = new Productos_Model();

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }

            $producto = $Productos->obtenerDetallesProducto($productoId);

            if ($producto) {

                if (isset($_SESSION['carrito'][$productoId])) {

                    $_SESSION['carrito'][$productoId]['cantidad']++;
                } else {

                    $_SESSION['carrito'][$productoId] = array(
                        'id' => $productoId,
                        'foto' => $producto['foto'],
                        'nombre' => $producto['nombre'],
                        'precio' => $producto['precio'],
                        'cantidad' => 1,

                    );
                }
                header("Location:index.php?c=page&a=productos");
            }
        }
    }

    public function SubirImagen($archivo)
    {
        $carpeta = "assets/img/fotos_Perfil/";

        if (!is_dir($carpeta)) {
            mkdir($carpeta);
        }

        $nombre_archivo = uniqid() . '_' . $archivo['name'];

        if (!empty($archivo['tmp_name']) && is_uploaded_file($archivo['tmp_name'])) {
            $tipo_archivo = $archivo['type'];
            $tamano_archivo = $archivo['size'];
            $temp_archivo = $archivo['tmp_name'];
            $error_archivo = $archivo['error'];

            if ($error_archivo === UPLOAD_ERR_OK) {
                move_uploaded_file($temp_archivo, $carpeta . $nombre_archivo);

                // Ajustar tamaño y redimensionar a 400x400 píxeles
                $image = Image::make($carpeta . $nombre_archivo);
                $image->resize(400, 400);
                $image->save($carpeta . $nombre_archivo);

                return $nombre_archivo;
            } else {
                // Manejar el error de carga de archivos aquí
            }
        } else {
            // El archivo está vacío o no se pudo cargar
            // Manejar el error de archivo vacío aquí
        }
    }
}
