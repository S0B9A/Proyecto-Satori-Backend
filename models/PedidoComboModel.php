<?php
class PedidoComboModel
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
            $vSql = "SELECT * FROM pedidos_combos;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getPedidoCombos($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT pc.id_pedido, pc.id_combo, pc.cantidad, pc.precio, pc.subtotal, c.nombre, c.imagen
            FROM pedidos_combos pc, combo c
            where c.id = pc.id_combo
            and pc.id_pedido = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
            
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
