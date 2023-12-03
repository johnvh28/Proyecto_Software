<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Psr7\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;


class VentaController
{
    public function __construct()
    {
        require_once "model/gestion_venta.php";
        require_once "model/persona.php";
    }


    public function clientes()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Clientes = new Venta_Model();
            $Cliente['clientes'] = $Clientes->ObtenerCliente();
            require_once "view/Gestion_ventas/clientes/clientes.php";
        }
    }

    
}

?>