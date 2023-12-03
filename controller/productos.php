<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Psr7\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;

class ProductosController
{
    public function __construct()
    {
        require_once "model/productos.php";
    }

    public function index()
    {
        $producto = new Productos_Model();
        $productos['productos'] = $producto->index();
        require_once "view/Productos/Productos/Productos.php";
    }
    /***
     * Productos metodos 
     */
    public function CrearProducto()
    {
        $Productos = new Productos_Model();
        $Categorias['productos'] = $Productos->CategoriasSubcategorias();
        require_once "view/Productos/Productos/CrearProductos.php";
    }
    public function AgregarDetalles()
    {
        $productoC = new Productos_Model();
        $id = $_GET['id'];
        $productosC['productoC'] = $productoC->ObtenerPcolor($id);
        $productosT['productoT'] = $productoC->ObtenerPtalla($id);
        $productosModelo['productoModelo'] = $productoC->ObtenerPModelos($id);
        $productosManga['productoManga'] = $productoC->ObtenerPManga($id);

        require_once "view/Productos/Productos/CrearDetallesProductos.php";
    }
    public function precio()
    {
        $productoC = new Productos_Model();
        $productosPrecio['precio'] = $productoC->ObtenerPPrecio();

        require_once "view/Productos/PrecioProductos/precio_productos.php";
    }
    public function aggcolor()
    {
        $producto = new Productos_Model();
        $prodColor["prodcolor"] = $producto->selectcolor();
        $productos["producto"] = $producto->selectproducto();
        require_once "view/Productos/Productos/crear_producto_color.php";
    }
    public function aggmanga()
    {
        $producto = new Productos_Model();
        $productos["producto"] = $producto->selectproducto();
        $prodManga["prodmanga"] = $producto->selectmanga();
        require_once "view/Productos/Productos/crear_producto_manga.php";
    }
    public function aggmodelo()
    {
        $producto = new Productos_Model();
        $productos["producto"] = $producto->selectproducto();
        $prodModelo["prodmodelo"] = $producto->selectmodelo();
        require_once "view/Productos/Productos/crear_producto_modelo.php";
    }
    public function aggtalla()
    {
        $producto = new Productos_Model();
        $productos["producto"] = $producto->selectproducto();
        $prodTalla["prodtalla"] = $producto->selecttalla();
        require_once "view/Productos/Productos/crear_producto_talla.php";
    }
    public function aggprecio()
    {
        $producto = new Productos_Model();
        $productos["producto"] = $producto->MostraProductoSinPrecio();
        require_once "view/Productos/PrecioProductos/crear_precio_producto.php";
    }
    public function GuadarProductos()
    {
        $Productos = new Productos_Model();
        $SubCategoria = $_POST['subcategoria'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $foto = $this->SubirImagen($_FILES['foto']);
        $Productos->InsertarProductos($SubCategoria, $nombre, $descripcion, $foto, $estado);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos");
    }
    public function actualizarproducto()
    {
        require_once "view/Productos/Productos/CrearProductos.php";
    }

    public function eliminarproducto()
    {
    }
    /*****
     * 
     */
    public function marcas()
    {
        $Marcas = new Productos_Model();
        $data['Listas'] = $Marcas->Mostrar($TABLA = 'marcas');

        require_once "view/Productos/Marcas/marcas.php";
    }

    public function crearMarca()
    {
        require_once "view/Productos/Marcas/crear_marca.php";
    }
    public function ActualizarMarca()
    {
        $Marcas = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionMarca['ActualizacionMarcas'] = $Marcas->ObtenerDatosActualizacion($id, $nombre = "marcas");
        require_once "view/Productos/Marcas/ActualizarMarcas.php";
    }

    public function GuardarMarca()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marca = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Marca->InsertarMarcas($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=marcas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }

    public function ActualizarMarcas()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Marcas->ActualizarMarcas($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=marcas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }

    public function EliminarMarca()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $Marcas->CambiarEstado($id, 2, $TABLA = 'marcas', $id_tabla = 'id');
            $Marcas->CambiarEstado($id, 2, $TABLA = 'modelos', $id_tabla = 'marca_id');
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=marcas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function modelos()
    {
        $Modelos = new Productos_Model();
        $data['Listas'] = $Modelos->MostrarModelos();

        require_once "view/Productos/Modelos/modelos.php";
    }
    public function CrearModelo()
    {
        $Selects = new Productos_Model();
        $Marcas['Marcas'] = $Selects->ObtenerMarcas();
        require_once "view/Productos/Modelos/crear_modelo.php";
    }

    public function GuardarModelo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Modelo = new Productos_Model();
            $nombre = $_POST['nombre'];
            $id_marca = $_POST['marca'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Modelo->InsertarModelos($nombre, $id_marca, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=modelos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ObtenerModelo()
    {
        $Modelo = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionModelo['ActualizacionModelos'] = $Modelo->ObtenerDatosActualizacion($id, $tabla = 'modelos');
        $Marcas['Marcas'] = $Modelo->ObtenerMarcas();
        require_once "view/Productos/Modelos/ActualizarModelo.php";
    }



    public function ActualizarModelo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $id_marca = $_POST['marca'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Marcas->ActualizarModelos($id, $id_marca, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=modelos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarModelo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $Marcas->CambiarEstado($id, 2, $TABLA = 'modelos', $id_tabla = 'id');
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=modelos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function tallas()
    {
        $Marcas = new Productos_Model();
        $data['Listas'] = $Marcas->Mostrar($TABLA = 'tallas');

        require_once "view/Productos/Tallas/tallas.php";
    }

    public function crearTalla()
    {
        require_once "view/Productos/Tallas/crear_talla.php";
    }
    public function ActualizarTalla()
    {
        $Talla = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionTalla['ActualizacionTalla'] = $Talla->ObtenerDatosActualizacion($id, $nombre = "tallas");
        require_once "view/Productos/Tallas/ActualizarTalla.php";
    }
    public function GuardarTalla()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Talla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Talla->InsertarTallas($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=tallas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarTallas()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tallas = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tallas->ActualizarTallas($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=tallas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarTalla()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $Marcas->CambiarEstado($id, 2, $TABLA = 'tallas', $id_tabla = 'id');

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=tallas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function telas()
    {
        $tela = new Productos_Model();
        $data['Listas'] = $tela->Mostrar($TABLA = 'tela');

        require_once "view/Productos/Telas/telas.php";
    }

    public function crearTela()
    {
        require_once "view/Productos/Telas/crear_tela.php";
    }
    public function ActualizarTela()
    {
        $Tabla = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionTela['ActualizacionTela'] = $Tabla->ObtenerDatosActualizacion($id, $nombre = "tela");
        require_once "view/Productos/Telas/ActualizarTela.php";
    }
    public function GuardarTela()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->InsertarTela($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=telas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarTelas()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tallas = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tallas->ActualizarTela($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=telas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarTela()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Marcas = new Productos_Model();
            $id = $_POST['id'];
            $Marcas->CambiarEstado($id, 2, $TABLA = 'tela', $id_tabla = 'id');

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=telas");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function estiloCuello()
    {
        $dato = new Productos_Model();
        $data['Listas'] = $dato->Mostrar($TABLA = 'estilo_cuello');

        require_once "view/Productos/EstiloCuello/estilocuello.php";
    }

    public function crearEstiloCuello()
    {
        require_once "view/Productos/EstiloCuello/crear_estilocuello.php";
    }
    public function ActualizaEstiloCuello()
    {
        $Tabla = new Productos_Model();
        $id = $_GET['id'];
        $Actualizacion['Actualizacion'] = $Tabla->ObtenerDatosActualizacion($id, $nombre = "estilo_cuello");
        require_once "view/Productos/EstiloCuello/ActualizarEstiloCuello.php";
    }
    public function GuardarEstilocuello()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->InsertarEstiloCuello($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=estiloCuello");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarEstilocuello()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->ActualizarEstiloCuello($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=estiloCuello");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarEstilocuello()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $Tabla->CambiarEstado($id, 2, $TABLA = 'estilo_cuello', $id_tabla = 'id');

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=estiloCuello");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function manga()
    {
        $dato = new Productos_Model();
        $data['Listas'] = $dato->Mostrar($TABLA = 'manga');

        require_once "view/Productos/Manga/manga.php";
    }

    public function crearManga()
    {
        require_once "view/Productos/Manga/crear_manga.php";
    }
    public function ActualizaManga()
    {
        $Tabla = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionManga['ActualizacionManga'] = $Tabla->ObtenerDatosActualizacion($id, $nombre = "manga");
        require_once "view/Productos/Manga/ActualizarManga.php";
    }
    public function GuardarManga()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->InsertarManga($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=manga");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarManga()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->ActualizarManga($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=manga");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarManga()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $Tabla->CambiarEstado($id, 2, $TABLA = 'manga', $id_tabla = 'id');

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=manga");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function color()
    {
        $dato = new Productos_Model();
        $data['Listas'] = $dato->Mostrar($TABLA = 'color');

        require_once "view/Productos/Color/color.php";
    }

    public function crearColor()
    {
        require_once "view/Productos/Color/crear_color.php";
    }
    public function ActualizaColor()
    {
        $Tabla = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionColor['ActualizacionColor'] = $Tabla->ObtenerDatosActualizacion($id, $nombre = "color");
        require_once "view/Productos/Color/ActualizarColor.php";
    }
    public function GuardarColor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->InsertarColor($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=color");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarColor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->ActualizarColor($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=color");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarColor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $Tabla->CambiarEstado($id, 2, $TABLA = 'color', $id_tabla = 'id');

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=color");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function categorias()
    {
        $dato = new Productos_Model();
        $data['Listas'] = $dato->Mostrar($TABLA = 'categorias');

        require_once "view/Productos/Categorias/categorias.php";
    }

    public function crearCategoria()
    {
        require_once "view/Productos/Categorias/crear_categoria.php";
    }
    public function ActualizaCategorias()
    {
        $Tabla = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionCategoria['ActualizacionCategoria'] = $Tabla->ObtenerDatosActualizacion($id, $nombre = "categorias");
        require_once "view/Productos/Categorias/ActualizarCategoria.php";
    }
    public function GuardarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->InsertarCategorias($nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=categorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Tabla = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Tabla->ActualizarCategoria($id, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=categorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Delete = new Productos_Model();
            $id = $_POST['id'];
            $Delete->CambiarEstado($id, 2, $TABLA = 'categorias', $id_tabla = 'id');
            $Delete->CambiarEstado($id, 2, $TABLA = 'subcategorias', $id_tabla = 'categoria_id');
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=categorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function subcategorias()
    {
        $Tabla = new Productos_Model();
        $data['Listas'] = $Tabla->MostrarSubcategorias();

        require_once "view/Productos/Subcategorias/subcategorias.php";
    }
    public function CrearSubcategoria()
    {
        $Selects = new Productos_Model();
        $Categoria['Categoria'] = $Selects->Obtenercategoria();
        require_once "view/Productos/Subcategorias/crear_subcategorias.php";
    }

    public function GuardarSubcategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Insert = new Productos_Model();
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Insert->InsertarSubCategorias($nombre, $id_categoria, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=productos&a=subcategorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ObtenerSubcategoria()
    {
        $Update = new Productos_Model();
        $id = $_GET['id'];
        $ActualizacionSubcategoria['Actualizacion'] = $Update->ObtenerDatosActualizacion($id, $tabla = 'subcategorias');
        $Categorias['Categorias'] = $Update->Obtenercategoria();
        require_once "view/Productos/Subcategorias/ActualizarSubcategorias.php";
    }

    public function ActualizarSubcategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Update = new Productos_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Update->ActualizarSubcategoria($id, $id_categoria, $nombre, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=productos&a=subcategorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarSubcategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Delete = new Productos_Model();
            $id = $_POST['id'];
            $Delete->CambiarEstado($id, 2, $TABLA = 'subcategorias', $id_tabla = 'id');
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=productos&a=subcategorias");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function SubirImagen($archivo)
    {
        $carpeta = "assets/img/productos/";

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
                $image->resize(250, 300);
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
    public function GuardarPColor()
    {
        $PColor = new Productos_Model();
        $producto = $_POST['producto'];
        $color = $_POST['color'];
        $estado = $_POST['estado'];
        $foto = $this->SubirImagen($_FILES['foto']);
        $PColor->InsertarPColor($producto,$color,$estado,$foto);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos&a=AgregarDetalles&id=".$producto);
    }
    public function GuardarPManga()
    {
        $PManga = new Productos_Model();
        $producto = $_POST['producto'];
        $manga = $_POST['manga'];
        $estado = $_POST['estado'];
        $foto = $this->SubirImagen($_FILES['foto']);
        $PManga->InsertarPManga($producto,$manga,$estado,$foto);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos&a=AgregarDetalles&id=".$producto);
    }
    public function GuardarPModelo()
    {
        $PManga = new Productos_Model();
        $producto = $_POST['producto'];
        $modelo = $_POST['modelo'];
        $estado = $_POST['estado'];
        $foto = $this->SubirImagen($_FILES['foto']);
        $PManga->InsertarPModelos($producto,$modelo,$estado,$foto);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos&a=AgregarDetalles&id=".$producto);
    }
    public function GuardarPTalla()
    {
        $PManga = new Productos_Model();
        $producto = $_POST['producto'];
        $talla = $_POST['talla'];
        $estado = $_POST['estado'];
        $foto = $this->SubirImagen($_FILES['foto']);
        $PManga->InsertarPTalla($producto,$talla,$estado,$foto);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos&a=AgregarDetalles&id=".$producto);
    }
    public function GuardarPPrecio()
    {
        $PManga = new Productos_Model();
        $producto = $_POST['producto'];
        $precio_compra = $_POST['precio_compra'];
        $margen_ganancia = $_POST['margen_ganancia'];
        $precio_venta = $_POST['precio_venta'];
        $estado = $_POST['estado'];
        $PManga->InsertarPPrecio($producto, $precio_compra, $margen_ganancia, $precio_venta, $estado);
        session_start();
        $_SESSION['tipo'] = "success";
        $_SESSION["mensaje"] = "Se ha registrado con exito";
        header("Location:index.php?c=productos&a=precio");
    }
    
}
