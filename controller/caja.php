<?php 
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
class CajaController
{
    public function __construct()
    {
        require_once "model/caja.php";
    }

    public function index()
    {
        $caja = new Caja_Model();
        $data['caja'] = $caja->index();
        require_once "view/Caja/caja/caja.php";
    }

    public function configuracion()
    {
        $configuracion = new  Caja_Model();
        $tipos["tipos"] = $configuracion->tipos_cajas();
        $monedas["monedas"] = $configuracion->divisas();
        $moneda["moneda"] = $configuracion->divisas();
        $pais['paises'] = $configuracion->select_divisas();
        $divisas['divisas'] = $configuracion->select_monedas();
        $divisa['divisa'] = $configuracion->select_monedas();
        $billetes['billetes'] = $configuracion->billetes();
        $moneda_local = $configuracion->mostra_moneda_local();
        $tipo_cambio['cambios'] = $configuracion->mostrar_cambio_del_dia();
        $mostra_cambio["cambio"] = $configuracion->mostra_cambio();
        require_once "view/Caja/Configuracion/configuracion.php";
    }
    public function ActualizaTipo()
    {
        $tipo_cambio = new Caja_Model();
        $id = $_GET['id'];
        $Actualizacion['Actualizacion'] = $tipo_cambio->ObtenerDatosActualizacionTipo($id);
        require_once("view/Caja/Configuracion/actualizar_tipo_caja.php");

    }
    public function Vista_crear()
    {
        require_once("view/Caja/Configuracion/crear_tipo_caja.php");
    }

    public function crear_tipo()
    {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $caja = new Caja_Model();
        $caja->InsertarTipoCaja($nombre, $descripcion, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha registrado correctamente";
        header("Location: index.php?c=caja&a=configuracion");
    }
    public function actualizar_tipo()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $caja = new Caja_Model();
        $caja->actualizarTipoCaja($id, $nombre, $descripcion, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha actualizado correctamente";
        header("Location: index.php?c=caja&a=configuracion");
    }

    public function eliminar_tipo()
    {
        $id = $_GET["id"];
        $caja = new Caja_Model();
        $caja->cambiarEstadoTipoCaja($id, 2);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha desactivado correctamente";
        header("Location: index.php?c=caja&a=configuracion");
    }
    public function crear_divisa()
    {
        require_once "view/Caja/Configuracion/crear_divisa.php";
    }
    public function crear_moneda()
    {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['simbolo'];
        $local = $_POST['local'];
        $estado = $_POST['estado'];
        $caja = new Caja_Model();
        $caja->InsertarDivisa($nombre, $descripcion, $local, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha registrado correctamente";
        header("Location: index.php?c=caja&a=configuracion");
    }
    public function actualizar_moneda()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['simbolo'];
        $local = $_POST['local'];
        $estado = $_POST['estado'];
        $caja = new Caja_Model();
        $caja->actualizarDivisa($id, $nombre, $descripcion, $local, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha actualizado correctamente";
        header("Location: index.php?c=caja&a=configuracion");
    }
    public function actualiza_moneda()
    {
        $Tabla = new Caja_Model();
        $id = $_GET['id'];
        $Actualizaciondivisa['Actualizacion'] = $Tabla->ObtenerDatosActualizacion($id);
        require_once("view/Caja/Configuracion/actualizar_divisa.php");
    }
    public function eliminar_monedas()
    {
        $id = $_GET["id"];
        $caja = new Caja_Model();
        $caja->cambiarEstadoDivisa($id, 2);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha desactivado correctamente".$id;
        header("Location: index.php?c=caja&a=configuracion");
    }
    public function subir_tipo_cambio()
    {
        $fila =5;
        $id = $_POST['moneda'];
        $tipo = new Caja_Model();
        if ($_FILES['archivo_excel']['error'] == UPLOAD_ERR_OK) {
            $archivo_tmp = $_FILES['archivo_excel']['tmp_name'];
            $spreadsheet = IOFactory::load($archivo_tmp);
            $worksheet = $spreadsheet->getActiveSheet();

            // Acceder a los datos del archivo Excel a partir de la fila 5
            for ($row = $fila; $row <= $worksheet->getHighestRow(); ++$row) {
                $fechaOriginal = $worksheet->getCell('A' . $row)->getValue();
                $columnaB = $worksheet->getCell('B' . $row)->getValue();

                $fechaMySQL = date('Y-m-d', strtotime($fechaOriginal));
                $tipo->InsertarTipoCambio($id, $fechaMySQL, $columnaB);
            }
            session_start();
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha registrado correctamente";
            header("Location: index.php?c=caja&a=configuracion");
        }
    }
    public function subir_tasa_cambio()
    {
        $moneda = new Caja_Model();
        $divisa["moneda"] = $moneda->select_moneda();
        require_once "view/Caja/Configuracion/subir_tasa_cambio.php";
    }
    public function vista_denominacion()
    {
        $tabla = new Caja_Model();
        $data['Listas'] = $tabla->MostrarDivisa();
        require_once "view/Caja/Configuracion/crear_denominacion.php";
    }
    public function crear_denominacion()
    {
        $denominacion = $_POST['nombre'];
        $estado = $_POST['estado'];
        $id_divisa = $_POST['moneda'];
        $caja = new Caja_Model();
        $resultado = $caja->InsertarMoneda($id_divisa, $denominacion,  $estado);
        if ($resultado) {
            session_start();
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha registrado correctamente";
            header("Location: index.php?c=caja&a=configuracion");
        } else {
            session_start();
            $_SESSION["tipo"] =  "error";
            $_SESSION['mensaje'] = "Ya existe la denominacion ingresada";
            header("Location: index.php?c=caja&a=configuracion");
        }
    }

    public function eliminar_denominacion()
    {
        $id = intval($_GET['id']);
        $caja = new Caja_Model();
        $caja->cambiarEstadoDenominacion($id, 2);
        session_start();

            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha desactivado correctamente";
            header("Location: index.php?c=caja&a=configuracion");

    }

    public function eliminar_divisa()
    {
        $id = intval($_GET['id']);
        $estado = intval($_GET['estado']);
        $caja = new Caja_Model();
        $caja->CambiarEstadoDivisa($id, $estado);
        session_start();
        if ($estado == 2) {
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha desactivado correctamente";
            header("Location: index.php?c=caja&a=configuracion");
        } else {
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha activado correctamente";
            header("Location: index.php?c=caja&a=configuracion");
        }
    }
 
    public function crear_caj()
    {
        $cajas = new Caja_Model();
        $tipo["tipos"] = $cajas->select_tipo();
        require_once "view/Caja/caja/crear_caja.php";
    }

    public function guardar_caja()
    {
        $tipo = $_POST['tipo'];
        $id_trabajador = $_POST['id_trabajador'];
        $estado = $_POST['estado'];
        $nombre = $_POST['nombre'];
        $cajas = new Caja_Model();
        $cajas->InsertarCaja($tipo,$id_trabajador, $nombre, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha registrado correctamente";
        header("Location:index.php?c=caja");
    }

    public function caja_actualizar()
    {
        $id = $_GET['id'];
        $cajas = new Caja_Model();
        $tipo["tipos"] = $cajas->select_tipo();
        $caja['caja'] = $cajas->get_caja($id);
        require_once "view/Caja/caja/actualizar_caja.php";
    }
    public function actualizar_caja()
    {
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        $id_trabajador = $_POST['id_trabajador'];
        $estado = $_POST['estado'];
        $nombre = $_POST['nombre'];
        $cajas = new Caja_Model();
        $cajas->actualizarCaja($id, $tipo, $id_trabajador, $nombre, $estado);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha registrado correctamente";
        header("Location:index.php?c=caja");
    }

    public function caja_eliminar()
    {
        $id = $_GET['id'];
        $caja = new Caja_Model();
        $caja->cambiarestadocaja($id, 2);
        session_start();
        $_SESSION["tipo"] =  "success";
        $_SESSION['mensaje'] = "Se ha desactivado correctamente";
        header("Location:index.php?c=caja");
    }

    public function aperturas()
    {
        $apertura = new Caja_Model();
        if (!isset($_SESSION)) {
            session_start();

        }
        if (isset($_SESSION['IdEmpleado'])) {
            $id_trabajador = $_SESSION['IdEmpleado'];
            $data['apertura'] = $apertura->mostrar_apertura();
            $aperturar['solicitud'] = $apertura->solicitud_apertura();
            //$aperturares['solicitudes'] = $apertura->solicitudes_apertura_acepta($id_trabajador);
            $caja['caja'] = $apertura->index2();
            $solicitud = $apertura->apertura_trabajador($id_trabajador);
          ///  var_dump($solicitud);
          // exit();
            require_once "view/Caja/Apertura/apertura.php";
        } else {
            // Manejar el caso donde 'id_trabajador' no está definido en $_SESSION
            // Puedes redirigir a otra página o mostrar un mensaje de error.
            echo "Error: 'id_empleado' no está definido en la sesión.";
        }
    }
    /**Aperturar  detalles */
    public function crear_apertura()
    {
        $apertura = new Caja_Model();
        $moneda['moneda'] = $apertura->select_divisa();

        require_once "view/Caja/Apertura/asignar_monto.php";
    }
    public function guardar_apertura()
    {
        $id = $_POST['id'];
        $id_trabajador = $_POST['id_trabajador'];
        $caja = new Caja_Model();
        $id_apertura = $caja->crearAperturaCaja($id, $id_trabajador, 1);
        $caja->cambiarEstadoCaja($id, 3);
        $carrito = json_decode($_POST['datosCarrito'], true);
        if ($carrito !== null) {
            foreach ($carrito as $producto) {

                $caja->guardarDetalleAperturaCaja($id_apertura, $producto['monedaId'], $producto['monto'], $producto['moneda'] * $producto['monto']);
            }
            session_start();
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha registrado correctamente tu solicitud";
            header("Location:index.php?c=caja&a=aperturas");
        } else {
            // Manejar el caso en el que el JSON no se pueda decodificar
            session_start();
            $_SESSION["tipo"] =  "error";
            $_SESSION['mensaje'] = "Ha ocurrido un error con tu solicitud";
            header("Location:index.php?c=caja&a=aperturas");
        }
    }

    public function autorizacion_apertura()
    {
        $id = $_GET['id'];
        $id_trabajador = $_GET['id_trabajador'];
        $estado = $_GET['estado'];
        $id_caja = $_GET['caja'];
        date_default_timezone_set('America/Managua');

        // Obtén la fecha actual
        $fecha_actual = date('Y-m-d');
        $timestamp = strtotime($fecha_actual);
        $fecha_formateada = date('Y-m-d', $timestamp);

        $caja = new Caja_Model();
        if ($estado = 2) {
            $caja->cambiar_apertura_caja($id, $id_trabajador, $fecha_formateada, $estado);
            $caja->cambiarEstadoCaja($id_caja, 4);
            session_start();
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha aperturado correctamente";
            header("Location:index.php?c=caja&a=aperturas");
        } elseif ($estado = 3) {
            $caja->cambiar_apertura_caja($id, $id_trabajador, $fecha_formateada, $estado);
            $caja->cambiarEstadoCaja($id_caja, 1);
            session_start();
            $_SESSION["tipo"] =  "success";
            $_SESSION['mensaje'] = "Se ha rechazado correctamente";
            header("Location:index.php?c=caja&a=aperturas");
        }
    }

}

?>