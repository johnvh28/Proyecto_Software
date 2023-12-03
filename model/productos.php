<?php
require_once  "model/persona.php";
class Productos_Model
{
    private $db;
    private $TABLA;
    private $modelo;
    private $Marcas;
    private $subcategoria;
    private $categoria;
    private $productos;
    private $tipotela;
    private $colorproducto;
    private $Color;
    private $Talla;
    private $Manga;
    private $Modelo;
    private $Producto;
    private $ObtenerColor;
    private $ObtenerManga;
    private $Modelos;
    private  $Pprecio;
    public function __construct()
    {
        $this->db = conectar::conexion();
        $this->TABLA = array();
        $this->modelo = array();
        $this->Marcas = array();
        $this->subcategoria = array();
        $this->categoria = array();
        $this->productos = array();
        $this->Color = array();
        $this->Talla = array();
        $this->Producto = array();
        $this->ObtenerColor = array();
        $this->ObtenerManga = array();
        $this->Modelos = array();
        $this->Pprecio = array();
    }


    public function CategoriasSubcategorias()
    {
        $sql = "SELECT c.id AS categoria_id, c.nombre AS categoria, sc.id AS subcategoria_id, sc.nombre AS subcategoria
            FROM categorias c
            JOIN subcategorias sc ON c.id = sc.categoria_id";
        $resultado = $this->db->query($sql);
        $categorias = array();
        while ($row = $resultado->fetch_assoc()) {
            $categoria_id = $row['categoria_id'];
            $categoria = $row['categoria'];
            $subcategoria_id = $row['subcategoria_id'];
            $subcategoria = $row['subcategoria'];
            if (!isset($categorias[$categoria_id])) {
                $categorias[$categoria_id] = array(
                    'nombre' => $categoria,
                    'subcategorias' => array(),
                );
            }
            $categorias[$categoria_id]['subcategorias'][] = array(
                'id' => $subcategoria_id,
                'nombre' => $subcategoria,
            );
        }
        return $categorias;
    }
    public function MostrarProductosPagina()
    {
        $sql = "SELECT p.*, pp.precio_venta AS precio, sc.nombre AS sub,c.nombre AS categoria FROM productos p
        JOIN precios_productos pp ON pp.producto_id = p.id
        JOIN subcategorias sc ON sc.id = p.subcategoria_id
        LEFT JOIN categorias c ON c.id = sc.categoria_id WHERE p.estado = 1";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            // Inicializar un array para almacenar los resultados
            $productosLadin = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $resultado->fetch_assoc()) {
                $productosLadin[] = $row;
            }

            // Devolver el array de resultados
            return $productosLadin;
        } else {
            // Si no hay resultados, devolver un array vacío
            return array();
        }
    }
    public function obtenerDetallesProducto($id)
    {
        $sql = "SELECT p.id,p.foto, p.nombre, pp.precio_venta AS precio FROM productos p
                JOIN precios_productos pp ON pp.producto_id = p.id WHERE p.id = $id";

        $resultado = $this->db->query($sql);

        // Verificar si la consulta fue exitosa y si se obtuvo al menos una fila
        if ($resultado && $resultado->num_rows > 0) {
            // Obtener la fila como un arreglo asociativo
            $producto = $resultado->fetch_assoc();

            // Liberar el resultado después de obtener los datos
            $resultado->free();

            return $producto;
        }

        // En caso de que la consulta no sea exitosa o no se encuentre el producto
        return null;
    }
    public function MostrarProductossubcategorias($Id)
    {
        $sql = "SELECT p.*, pp.precio_venta AS precio, sc.nombre AS sub,c.nombre AS categoria FROM productos p
        JOIN precios_productos pp ON pp.producto_id = p.id
        JOIN subcategorias sc ON sc.id = p.subcategoria_id
        LEFT JOIN categorias c ON c.id = sc.categoria_id WHERE p.estado = 1 AND p.subcategoria_id = $Id";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            // Inicializar un array para almacenar los resultados
            $productosLadin = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $resultado->fetch_assoc()) {
                $productosLadin[] = $row;
            }

            // Devolver el array de resultados
            return $productosLadin;
        } else {
            // Si no hay resultados, devolver un array vacío
            return array();
        }
    }
    
    public function MostrarProductosMangas($Id)
    {
        $sql = "SELECT p.id,pt.foto, p.nombre, pp.precio_venta AS precio FROM productos p
        JOIN precios_productos pp ON pp.producto_id = p.id 
        JOIN producto_manga pt ON pt.id_producto =p.id
        WHERE p.estado = 1 AND pt.id_manga = $Id";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            // Inicializar un array para almacenar los resultados
            $productosLadin = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $resultado->fetch_assoc()) {
                $productosLadin[] = $row;
            }

            // Devolver el array de resultados
            return $productosLadin;
        } else {
            // Si no hay resultados, devolver un array vacío
            return array();
        }
    } 
    public function MostrarProductosModelos($Id)
    {
        $sql = "SELECT p.id,pt.foto, p.nombre, pp.precio_venta AS precio FROM productos p
        JOIN precios_productos pp ON pp.producto_id = p.id 
        JOIN producto_modelo pt ON pt.id_producto =p.id
        WHERE p.estado = 1 AND pt.id_modelo = $Id";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            // Inicializar un array para almacenar los resultados
            $productosLadin = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $resultado->fetch_assoc()) {
                $productosLadin[] = $row;
            }

            // Devolver el array de resultados
            return $productosLadin;
        } else {
            // Si no hay resultados, devolver un array vacío
            return array();
        }
    } 
    
    public function MostrarProductosColores($Id)
    {
        $sql = "SELECT p.id,pt.foto, p.nombre, pp.precio_venta AS precio FROM productos p
        JOIN precios_productos pp ON pp.producto_id = p.id 
        JOIN producto_color pt ON pt.id_producto =p.id
        WHERE p.estado = 1 AND pt.id_color = $Id";
        $resultado = $this->db->query($sql);
        if ($resultado->num_rows > 0) {
            // Inicializar un array para almacenar los resultados
            $productosLadin = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $resultado->fetch_assoc()) {
                $productosLadin[] = $row;
            }

            // Devolver el array de resultados
            return $productosLadin;
        } else {
            // Si no hay resultados, devolver un array vacío
            return array();
        }
    } 
    public function CategoriasSubcategoriasLimitadas()
    {
        $sql = "SELECT c.id AS categoria_id, c.nombre AS categoria, sc.id AS subcategoria_id, sc.nombre AS subcategoria
                FROM (SELECT id, nombre FROM categorias LIMIT 3) c
                LEFT JOIN subcategorias sc ON c.id = sc.categoria_id";

        $resultado = $this->db->query($sql);
        $categoriasSub = array(); // Cambiado el nombre de la variable

        while ($row = $resultado->fetch_assoc()) {
            $categoria_id = $row['categoria_id'];
            $categoria_nombre = $row['categoria']; // Cambiado el nombre de la variable
            $subcategoria_id = $row['subcategoria_id'];
            $subcategoria_nombre = $row['subcategoria']; // Cambiado el nombre de la variable

            if (!isset($categoriasSub[$categoria_id])) {
                $categoriasSub[$categoria_id] = array(
                    'nombre' => $categoria_nombre,
                    'subcategorias' => array(),
                );
            }

            $categoriasSub[$categoria_id]['subcategorias'][] = array(
                'id' => $subcategoria_id,
                'nombre' => $subcategoria_nombre,
            );
        }

        return $categoriasSub;
    }

    public function Mostrar($TABLA)
    {
        $TABLA = $this->db->real_escape_string($TABLA);
        $sql = "SELECT * FROM $TABLA";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->TABLA[] = $row;
                }
                return $this->TABLA;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }

    public function CambiarEstado($id, $estado, $TABLA, $id_tabla)
    {
        $TABLA = $this->db->real_escape_string($TABLA);
        $id_tabla = $this->db->real_escape_string($id_tabla);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT); // Convertir a 1 o 0

        if (!$id) {
            return false; // ID no válido
        }

        $sql = "UPDATE $TABLA SET estado = $estado WHERE $id_tabla = $id";

        if ($this->db->query($sql)) {
            return $id;
        } else {
            return "Error al cambiar el estado: " . $this->db->error;
        }
    }


    public function ObtenerDatosActualizacion($id, $TABLA)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $TABLA = $this->db->real_escape_string($TABLA);
        $sql = "SELECT * FROM $TABLA WHERE id=$id";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row;
    }
    public function InsertarMarcas($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "marcas");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO marcas (id,nombre,descripcion,estado) VALUES($id, '$nombre', '$descripcion', '$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarMarcas($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE marcas SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    public function MostrarModelos()
    {
        $sql = "SELECT M.id as id, M.nombre as Modelo, l.nombre as Marca, M.descripcion as Descripcion, M.estado as Estado FROM modelos M JOIN marcas l ON l.id = M.marca_id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->modelo[] = $row;
                }
                return $this->modelo;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }

    public function ObtenerMarcas()
    {
        $sql = "SELECT id, nombre FROM marcas WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Marcas[] = $row;
        }
        return $this->Marcas;
    }

    public function InsertarModelos($nombre, $id_marca, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($modelos = "modelos");
        $id_marca = filter_var($id_marca, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO modelos(id,nombre,marca_id,descripcion,estado) VALUES($id,'$nombre','$id_marca','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarModelos($id, $id_marca, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $id_marca = filter_var($id_marca, FILTER_VALIDATE_INT);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE modelos SET marca_id='$id_marca', nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    public function InsertarTallas($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tallas = "tallas");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO tallas (id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarTallas($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE tallas SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    public function InsertarTela($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($tela = "tela");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO tela (id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function ActualizarTela($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE tela SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }


    public function InsertarEstiloCuello($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($estilo_cuello = "estilo_cuello");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO estilo_cuello(id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarEstiloCuello($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE estilo_cuello SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }


    public function InsertarManga($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($manga = "manga");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO manga(id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarManga($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE manga SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }


    public function InsertarColor($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($color = "color");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO color (id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarColor($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE color SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    public function InsertarCategorias($nombre, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($categorias = "categorias");
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO categorias (id,nombre,descripcion,estado) VALUES($id,'$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarCategoria($id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE categorias
         SET nombre='$nombre',
          descripcion='$descripcion',
           estado='$estado'
         WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }

    public function MostrarSubcategorias()
    {
        $sql = "SELECT s.id as id, s.nombre as nombre, c.nombre as categoria, s.descripcion as descripcion, s.estado as estado FROM subcategorias s JOIN categorias c ON c.id = s.categoria_id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->subcategoria[] = $row;
                }
                return $this->subcategoria;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }

    public function Obtenercategoria()
    {
        $sql = "SELECT id, nombre FROM categorias WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->categoria[] = $row;
        }
        return $this->categoria;
    }
    public function InsertarSubCategorias($nombre, $categoria_id, $descripcion, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($subcategorias = "subcategorias");
        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO subcategorias (id,categoria_id,nombre,descripcion,estado) VALUES($id,'$categoria_id','$nombre','$descripcion','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ActualizarSubcategoria($id, $categoria_id, $nombre, $descripcion, $estado)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);

        $sql = "UPDATE subcategorias SET categoria_id='$categoria_id', nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id";

        if ($this->db->query($sql)) {
            return true; // La actualización fue exitosa
        } else {
            return "Error al realizar la actualización: " . $this->db->error;
        }
    }
    /**
     * Productos
     */

    public function index()
    {
        $sql = "SELECT p.*, sc.nombre AS sub,c.nombre AS categoria FROM productos p
        INNER JOIN subcategorias sc ON sc.id = p.subcategoria_id
        INNER JOIN categorias c ON  c.id = sc.categoria_id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->productos[] = $row;
                }
                return $this->productos;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function BuscarCategoriaId($id)
    {
        $query = "SELECT categoria_id FROM subcategorias WHERE id = $id";
        $resultado = $this->db->query($query);
        if ($resultado->num_rows > 0) {
            // Obtener el resultado como una matriz asociativa
            $row = $resultado->fetch_assoc();
            // Devolver el valor de id_ubicaciones
            return $row["categoria_id"];
        } else {
            // Si no hay resultados, devolver null
            return null;
        }
    }
    public function CodigoProducto($id_categoria, $id_sub_categoria, $id_producto)
    {
        $codigo_categoria = str_pad($id_categoria, 2, '0', STR_PAD_LEFT);
        $codigo_sub_categoria = str_pad($id_sub_categoria, 2, '0', STR_PAD_LEFT);
        $codigo_producto = str_pad($id_producto, 2, '0', STR_PAD_LEFT);

        return 'P-' . ' ' . $codigo_categoria . '-' . $codigo_sub_categoria . '-' . $codigo_producto;
    }

    public function InsertarProductos($subcategorias_id, $nombre, $descripcion, $foto, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($productos = "productos");
        $subcategorias_id = filter_var($subcategorias_id, FILTER_VALIDATE_INT);
        $IdCategoria = $this->BuscarCategoriaId($subcategorias_id);
        $codigo = $this->CodigoProducto($IdCategoria, $subcategorias_id, $id);
        $nombre = $this->db->real_escape_string($nombre);
        $descripcion = $this->db->real_escape_string($descripcion);
        $foto = $this->db->real_escape_string($foto);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO productos (id,subcategoria_id,codigo,nombre,descripcion,foto,estado) VALUES($id,'$subcategorias_id','$codigo','$nombre','$descripcion','$foto','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }

    public function InsertarPrecioProductos($producto_id, $precio_compra, $margen_ganancia, $precio_venta, $fecha_registro, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($preciosproductos = "precios_productos");
        $producto_id = filter_var($producto_id, FILTER_VALIDATE_INT);
        $precio_compra = filter_var($precio_compra, FILTER_VALIDATE_INT);
        $margen_ganancia = filter_var($margen_ganancia, FILTER_VALIDATE_INT);
        $precio_venta = filter_var($precio_venta, FILTER_VALIDATE_INT);
        $fecha_registro = $this->db->real_escape_string($fecha_registro);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO precios_productos(id,producto_id,precio_compra,margen_ganancia,precio_venta,fecha_registro,estado) VALUES($id,'$producto_id','$precio_compra','$margen_ganancia','$precio_venta','$fecha_registro','$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function ObtenerPcolor($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT 
        pc.id , p.nombre AS nombre_producto,c.nombre AS nombre_color,pc.estado,pc.foto
        FROM producto_color pc
                INNER JOIN productos p ON pc.id_producto = p.id
                INNER JOIN color c ON  pc.id_color = c.id WHERE pc.id_producto =$id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Color[] = $row;
                }
                return $this->Color;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerPTalla($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT 
        pt.id , p.nombre AS nombre_producto,t.nombre AS nombre_talla,pt.estado,pt.foto
        FROM producto_talla pt
                INNER JOIN productos p ON pt.id_producto = p.id
                INNER JOIN tallas t ON  pt.id_talla = t.id WHERE pt.id_producto = $id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Talla[] = $row;
                }
                return $this->Talla;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerPManga($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT 
        pm.id , p.nombre AS nombre_producto,m.nombre AS nombre_manga,pm.estado,pm.foto
        FROM producto_manga pm
                INNER JOIN productos p ON pm.id_producto = p.id
                INNER JOIN manga m ON  pm.id_manga = m.id WHERE pm.id_producto = $id";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Manga[] = $row;
                }
                return $this->Manga;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
    public function ObtenerPModelos($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "SELECT 
        pm.id , p.nombre AS nombre_producto,m.nombre AS nombre_modelo,pm.estado,pm.foto
        FROM producto_modelos pm
                INNER JOIN productos p ON pm.id_producto = p.id
                INNER JOIN modelos m ON  pm.id_modelo = m.id WHERE pm.id_producto = $id";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Modelos[] = $row;
        }
        return $this->Modelos;
    }
    public function ObtenerPPrecio()
    {
        $sql = "SELECT
        pp.id,
        p.nombre AS nombre_producto,
        pp.precio_compra,
        pp.margen_ganancia,
        pp.precio_venta,
        pp.fecha_registro,
        pp.estado
    FROM
        precios_productos pp
    INNER JOIN productos p ON
        pp.producto_id = p.id";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {

            $this->Pprecio[] = $row;
        }
        return $this->Pprecio;
    }
    public function selectproducto()
    {
        $sql = "SELECT id, nombre FROM productos WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Producto[] = $row;
        }
        return $this->Producto;
    }
    public function selectcolor()
    {
        $sql = "SELECT id, nombre FROM color WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->ObtenerColor[] = $row;
        }
        return $this->ObtenerColor;
    }
    public function selectmanga()
    {
        $sql = "SELECT id, nombre FROM manga WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->ObtenerManga[] = $row;
        }
        return $this->ObtenerManga;
    }
    public function selecttalla()
    {
        $sql = "SELECT id, nombre FROM tallas WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Talla[] = $row;
        }
        return $this->Talla;
    }
    public function selectmodelo()
    {
        $sql = "SELECT id, nombre FROM modelos WHERE estado = 1";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->Modelo[] = $row;
        }
        return $this->Modelo;
    }
    public function InsertarPColor($id_producto, $id_color, $estado, $foto)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "producto_color");
        $foto = $this->db->real_escape_string($foto);
        $id_color = filter_var($id_color, FILTER_VALIDATE_INT);
        $id_producto = filter_var($id_producto, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `producto_color`(`id`, `id_producto`, `id_color`, `estado`, `foto`) VALUES ($id,'$id_producto','$id_color','$estado','$foto')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function InsertarPManga($id_producto, $id_manga, $estado, $foto)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "producto_manga");
        $foto = $this->db->real_escape_string($foto);
        $id_manga = filter_var($id_manga, FILTER_VALIDATE_INT);
        $id_producto = filter_var($id_producto, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `producto_manga`(`id`, `id_producto`, `id_manga`, `estado`, `foto`) VALUES ($id,'$id_producto','$id_manga','$estado','$foto')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function InsertarPTalla($id_producto, $id_talla, $estado, $foto)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "producto_talla");
        $foto = $this->db->real_escape_string($foto);
        $id_talla = filter_var($id_talla, FILTER_VALIDATE_INT);
        $id_producto = filter_var($id_producto, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `producto_talla`(`id`, `id_producto`, `id_talla`, `estado`, `foto`) VALUES ($id,'$id_producto','$id_talla','$estado','$foto')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function InsertarPModelos($id_producto, $id_modelo, $estado, $foto)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "producto_modelos");
        $foto = $this->db->real_escape_string($foto);
        $id_modelo = filter_var($id_modelo, FILTER_VALIDATE_INT);
        $id_producto = filter_var($id_producto, FILTER_VALIDATE_INT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `producto_modelos`(`id`, `id_producto`, `id_modelo`, `estado`, `foto`) VALUES ($id,'$id_producto','$id_modelo','$estado','$foto')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function InsertarPPrecio($producto_id, $precio_compra, $margen_ganancia, $precio_venta, $estado)
    {
        $persona = new Persona_model();
        $id = $persona->ObtenerNuevoId($Tabla = "precios_productos");
        $producto_id = filter_var($producto_id, FILTER_VALIDATE_INT);
        $precio_compra = filter_var($precio_compra, FILTER_VALIDATE_FLOAT);
        $margen_ganancia = filter_var($margen_ganancia, FILTER_VALIDATE_FLOAT);
        $precio_venta = filter_var($precio_venta, FILTER_VALIDATE_FLOAT);
        $estado = filter_var($estado, FILTER_VALIDATE_INT);
        $sql = "INSERT INTO `precios_productos`(`id`, `producto_id`, `precio_compra`, `margen_ganancia`, `precio_venta`, `fecha_registro`, `estado`) VALUES ($id,'$producto_id','$precio_compra','$margen_ganancia','$precio_venta',NOW(),'$estado')";

        if ($this->db->query($sql)) {
            // La inserción fue exitosa
            return $this->db->insert_id;
        } else {
            // Hubo un error en la inserción
            return $mensaje = "Error al realizar la inserción: " . $this->db->error;
        }
    }
    public function MostraProductoSinPrecio()
    {
        $sql = "SELECT
        p.id ,p.nombre
    FROM
        productos p
    WHERE
        p.estado = 1 AND NOT EXISTS(
        SELECT
            producto_id
        FROM
            precios_productos pp
        WHERE
            pp.producto_id = p.id)";
        $resultado = $this->db->query($sql);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $this->Talla[] = $row;
                }
                return $this->Talla;
            } else {
                return array(); // Si no hay datos, retornar null o un mensaje de error, según convenga
            }
        }
    }
}
