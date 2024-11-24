<?php

use Pusher\Pusher;

class PedidoModel
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
            $vSql = "SELECT * FROM pedido order by fecha asc;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if (!empty($vResultado) && is_array($vResultado)) {

                for ($i = 0; $i <= count($vResultado) - 1; $i++) {
                    $vResultado[$i] = $this->get($vResultado[$i]->id);
                }
            }

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function PedidosPorUsuarioID($idUsuario)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM pedido where id_cliente = $idUsuario order by fecha asc;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if (!empty($vResultado) && is_array($vResultado)) {

                for ($i = 0; $i <= count($vResultado) - 1; $i++) {
                    $vResultado[$i] = $this->get($vResultado[$i]->id);
                }
            }

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {
        $vResultado = null;

        try {

            $PedidoProductoModelo = new PedidoProductoModel();
            $PedidoComboModelo = new PedidoComboModel();
            $usuarioModelo = new UsuarioModel();

            //Consulta sql
            $vSql = "SELECT * FROM pedido where id = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if (!empty($vResultado)) {
                $vResultado = $vResultado[0];

                //Cliente
                $vResultado->cliente = $usuarioModelo->get($vResultado->id_cliente);

                //Lista de productos
                $vResultado->productos = $PedidoProductoModelo->getPedidoProductos($id);

                //Lista de combos
                $vResultado->combos = $PedidoComboModelo->getPedidoCombos($id);
            }

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }



    public function getPedidoMasReciente()
    {
        $vResultado = null;
        try {
            //Consulta sql
            $vSql = " SELECT *  FROM pedido ORDER BY id DESC LIMIT 1;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if (!empty($vResultado)) {
                $vResultado = $vResultado[0];
            }

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function create($objeto)
    {
        try {
            $fechaReact = $objeto->pedido_date;
            // Crear un objeto DateTime a partir de la cadena de fecha
            // Convertir la fecha al formato deseado para la base de datos
            $fechaBD = date('Y-m-d', strtotime($fechaReact));

            //Consulta sql
            $vSql = "INSERT INTO pedido (id_cliente, id_encargado, fecha, estado, metodo_entrega, direccion, costo, subtotal, impuesto, Observacion_combo, Observacion_pedido) " .
                "VALUES ('$objeto->cliente_id', '$objeto->encargado_id', '$fechaBD', 'Pendiente de pago', '$objeto->tipo_pedido', '$objeto->indicaciones_ubicacion', '$objeto->total', '$objeto->subtotal', '$objeto->impuesto', '$objeto->ObservacionCombos', '$objeto->ObservacionProducto')";


            //Ejecutar la consulta
            $idPedido = $this->enlace->executeSQL_DML_last($vSql);

            //Insertar productos
            foreach ($objeto->productos as $item) {
                $sql = "INSERT INTO pedidos_productos
                    (id_pedido, id_producto, precio, cantidad, subtotal)
                    VALUES
                    ($idPedido, $item->id, $item->precio, $item->cantidad, $item->subtotal);";

                $vResultadoM = $this->enlace->executeSQL_DML($sql);
            }

            //Insertar combos
            foreach ($objeto->combos as $item) {
                $sql = "INSERT INTO pedidos_combos
                        (id_pedido, id_combo, precio, cantidad, subtotal)
                        VALUES
                        ($idPedido, $item->id, $item->precio, $item->cantidad, $item->subtotal);";

                $vResultadoM = $this->enlace->executeSQL_DML($sql);
            }

            // Retornar el objeto creado
            return $this->get($idPedido);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    /**
     * Actualizar producto
     * @param $objeto producto a actualizar
     * @return $this->get($idproducto) - Objeto producto
     */
    //
    public function updatePedidoPorPago($objeto)
    {
        try {

            // Consulta SQL
            $sql = "UPDATE pedido SET metodo_pago = '$objeto->metodo_pago', estado = 'Aceptada'  WHERE id = $objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);

            //Retornar producto actualizado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            handleException($e);
        }
    }


    /**
     * Actualizar pedido
     * @param $objeto pedido a actualizar
     * @return $this->get($idpedido) - Objeto pedido
     */
    //
    public function update($objeto)
    {
        try {
            // Consulta SQL para actualizar el pedido
            $sql = "UPDATE pedido SET estado = '$objeto->estado' WHERE id = $objeto->id";
            $cResults = $this->enlace->executeSQL_DML($sql);

            // Obtén el pedido actualizado
            $pedidoActualizado = $this->get($objeto->id);

            // Configura Pusher
            $options = [
                'cluster' => 'us2', // Cambia esto por el cluster que te asigne Pusher
                'useTLS' => true
            ];
            $pusher = new Pusher(
                '6044eb48c974063b6561', // Reemplaza con tu clave de la aplicación
                'c37b577f1bc42a492ac8',       // Reemplaza con tu secreto de la aplicación
                '1893850',           // Reemplaza con tu ID de la aplicación
                $options
            );

            // Envía el evento a Pusher
            $data = [
                'pedido' => [
                    'id' => $pedidoActualizado->id,
                    'estado' => $pedidoActualizado->estado
                ]
            ];
            $pusher->trigger('pedido-channel', 'estado-actualizado', $data);

            // Retornar pedido actualizado
            return $pedidoActualizado;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
