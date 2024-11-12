<?php
class PedidoProductoModel
{
    public $enlace;
    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM pedidos_productos;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getPedidoProductos($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT pp.id_pedido, pp.id_producto, pp.cantidadProductos, pp.precio, pp.subtotal, pp.total, p.nombre 
            FROM pedidos_productos pp, producto p
            where p.id = pp.id_producto
            and pp.id_pedido = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
            
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
