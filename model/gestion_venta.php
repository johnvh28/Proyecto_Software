<?php
require_once  "model/persona.php";

class Venta_Model
{
    private $db;
    public function __construct()
    {
        $this->db = conectar::conexion();
    }
    public function InsertarCliente($id_persona,$tipo_cliente,$estado)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "cliente");
            $id_persona = filter_var($id_persona, FILTER_VALIDATE_INT);
            $tipo_cliente = filter_var($tipo_cliente, FILTER_VALIDATE_INT);
            $estado = filter_var($estado, FILTER_VALIDATE_INT);
            $sql = "INSERT INTO `cliente`(`id`, `id_persona`, `tipo_cliente`, `estado`) VALUES ($id,'$id_persona','$tipo_cliente','$estado')";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }

    }
    public function InsertarPedido($cliente_id,$Subtotal,$descuento,$total,$estado)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "pedido");
            $cliente_id = filter_var($cliente_id, FILTER_VALIDATE_INT);
            $Subtotal = filter_var($Subtotal, FILTER_VALIDATE_FLOAT);
            $descuento = filter_var($descuento, FILTER_VALIDATE_FLOAT);
            $total = filter_var($total, FILTER_VALIDATE_FLOAT);
            $estado = $this->db->real_escape_string($estado);
            $sql = "INSERT INTO `pedido`(`id`, `cliente_id`, `fecha_pedido`, `subtotal`, `descuento`, `total`, `estado`) VALUES ($id,'$cliente_id',NOW(),'$Subtotal','$descuento','$total','$estado')";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }

    }
    public function InsertarDetallePedido($pedido_id,$producto_id,$cantidad,$precio_unitario)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "detalle_pedido");
            $pedido_id = filter_var($pedido_id, FILTER_VALIDATE_INT);
            $producto_id = filter_var($producto_id, FILTER_VALIDATE_INT);
            $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT);
            $precio_unitario = filter_var($precio_unitario, FILTER_VALIDATE_FLOAT);

            $sql = "INSERT INTO `detalle_pedido`(`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES ($id,'$pedido_id','$producto_id','$cantidad','$precio_unitario')";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }
    }
    public function Insertarventa($id_cliente,$id_trabajador,$codigo,$subtotal,$descuento,$impuesto,$total,$tipo_venta,$estado)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "venta");
            $id_cliente = filter_var($id_cliente, FILTER_VALIDATE_INT);
            $id_trabajador = filter_var($id_trabajador, FILTER_VALIDATE_INT);
            $codigo = $this->db->real_escape_string($codigo);
            $subtotal = filter_var($subtotal, FILTER_VALIDATE_FLOAT);
            $descuento = filter_var($descuento, FILTER_VALIDATE_FLOAT);
            $impuesto = filter_var($impuesto, FILTER_VALIDATE_FLOAT);
            $total = filter_var($total, FILTER_VALIDATE_FLOAT);
            $tipo_venta = $this->db->real_escape_string($tipo_venta);
            $estado = filter_var($estado, FILTER_VALIDATE_INT);

            $sql = "INSERT INTO `venta`(
                `id`,
                `id_cliente`,
                `id_trabajador`,
                `codigo`,
                `subtotal`,
                `descuento`,
                `impuesto`,
                `total`,
                `fecha_venta`,
                `tipo_venta`,
                `estado`
            )
            VALUES(
                '$id,
                '$id_cliente',
                '$id_trabajador',
                '$codigo',
                '$subtotal',
                '$descuento',
                '$impuesto',
                '$total',
                NOW(),
                '$tipo_venta',
                '$estado'
            )";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }
    }
    public function InsertarDetalleVenta($id_venta,$id_pedido,$monto)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "detalle_venta");
            $id_venta = filter_var($id_venta, FILTER_VALIDATE_INT);
            $id_pedido = filter_var($id_pedido, FILTER_VALIDATE_INT);
            $monto = filter_var($monto, FILTER_VALIDATE_FLOAT);

            $sql = "INSERT INTO `detalle_venta`(`id`, `id_venta`, `id_pedido`, `monto`) VALUES ($id,'$id_venta','$id_pedido','$monto')";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }
    }
    public function InsertarEntregaPedido($id_venta,$codigo,$estado,$asignado_por,$realizado_por,$observaciones)
    {

            $persona = new Persona_model();
            $id = $persona->ObtenerNuevoId($Tabla = "entrega_pedido");
            $id_venta = filter_var($id_venta, FILTER_VALIDATE_INT);
            $codigo = $this->db->real_escape_string($codigo);
            $estado = filter_var($estado, FILTER_VALIDATE_INT);
            $asignado_por = filter_var($asignado_por, FILTER_VALIDATE_INT);
            $realizado_por = filter_var($realizado_por, FILTER_VALIDATE_INT);
            $observaciones = $this->db->real_escape_string($observaciones);

            $sql = "INSERT INTO `entrega_pedido`(`id`, `id_venta`, `codigo`, `fecha_entrega`, `estado`, `asignado_por`, `realizado_por`, `observaciones`) VALUES ($id,'$id_venta','$codigo',NOW(),'$estado','$asignado_por','$realizado_por','$observaciones')";
    
            if ($this->db->query($sql)) {
                // La inserción fue exitosa
                return $this->db->insert_id;
            } else {
                // Hubo un error en la inserción
                return $mensaje = "Error al realizar la inserción: " . $this->db->error;
            }
    }
   
}


?>