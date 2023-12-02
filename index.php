<?php
require_once "config/config.php";
require_once "core/router.php";
require_once "config/conexion.php";
require_once "controller/page.php";
require_once "controller/negocio.php";
require_once "controller/productos.php";
require_once "controller/usuarios.php";
require_once "controller/caja.php";
if (isset($_GET['c'])) {

    $controlador = cargarControlador($_GET['c']);

    if (isset($_GET['a'])) {
        if (isset($_GET['id'])) {
            cargarAccion($controlador, $_GET['a'], $_GET['id']);
        } else {
            cargarAccion($controlador, $_GET['a']);
        }
    } else {
        cargarAccion($controlador, ACCION_PRINCIPAL);
    }

} else {

    $controlador = cargarControlador(CONTROLADOR_PRINCIPAL);
    $accionTmp = ACCION_PRINCIPAL;
    $controlador->$accionTmp();
}
