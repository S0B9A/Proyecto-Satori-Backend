<?php

class CocinaModel
{
    public $enlace;
    public function __construct()
    {

        $this->enlace = new MySqlConnect();
    }


    public function get($id)
    {
        try {

            $productoModel = new ProductoModel();


            $vSql = "SELECT * FROM cocina WHERE id = $id;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];
                //Producto
                $productoID =  $vResultado->id_producto;
                $productoInformacion = $productoModel->get($productoID);
                $vResultado->productoInformacion = $productoInformacion;
            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }


    public function getListaDeProductosPorPedido($id)
    {
        try {

            $productoModel = new ProductoModel();


            $vSql = "SELECT id, id_producto, id_estacion, estado FROM cocina WHERE id_pedido = $id;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {
                foreach ($vResultado as $producto) {

                    //Producto
                    $productoID =  $producto->id_producto;
                    $productoInformacion = $productoModel->get($productoID);
                    $producto->productoInformacion = $productoInformacion;
                }
            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }


    public function create($idPedido)
    {
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->get($idPedido);

        try {

            if (isset($pedido->productos) && $pedido->productos !== null) {
                //Insertar productos a cocina
                foreach ($pedido->productos as $item) {

                    $cantidadProducto = $item->cantidad;

                    for ($i = 0; $i < $cantidadProducto; $i++) {
                        $sql = "INSERT INTO cocina (id_pedido, id_producto) VALUES ($item->id_pedido, $item->id_producto);";
                        $vResultadoM = $this->enlace->executeSQL_DML($sql);
                    }
                }
            }

            //Insertar combos a cocina
            if (isset($pedido->combos) && $pedido->combos !== null) {
                foreach ($pedido->combos as $item) {

                    $cantidadcombo = $item->cantidad;

                    for ($i = 0; $i < $cantidadcombo; $i++) {
                        $ComboModel = new ComboModel();
                        $combo = $ComboModel->get($item->id_combo);
                        $Productos = $combo->productos;

                        foreach ($Productos as $producto) {
                            $sql = "INSERT INTO cocina (id_pedido, id_producto) VALUES ($item->id_pedido, $producto->id);";
                            $vResultadoM = $this->enlace->executeSQL_DML($sql);
                        }
                    }
                }
            }

            // Retornar el objeto creado
            return $pedido;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Actualizar pedidoCocina
     * @param $objeto combo a actualizar
     * @return $this->get($idcombo) - Objeto combo
     */
    //
    public function update($objeto)
    {
        try {

            // Consulta SQL
            $sql = "UPDATE cocina SET 
                    estado = '$objeto->estado', id_estacion = '$objeto->id_estacion'
                    WHERE id = $objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);


            //Retornar combo actualizado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
