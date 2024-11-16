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
            $fechaReact = $objeto->fecha;
            // Crear un objeto DateTime a partir de la cadena de fecha
            // Convertir la fecha al formato deseado para la base de datos
            $fechaBD = date('Y-m-d', strtotime($fechaReact));

            //Consulta sql

            $vSql = "INSERT INTO pedido
                (id_cliente, estado, metodo_entrega, direccion, fecha, costo)
                VALUES
                ($objeto->id_cliente,'$objeto->estado','$objeto->metodo_entrega','$objeto->direccion','$fechaBD',$objeto->costo);";

            //Ejecutar la consulta
            $idPedido = $this->enlace->executeSQL_DML_last($vSql);

            //Insertar productos
            foreach ($objeto->productos as $item) {
                $sql = "INSERT INTO pedidos_productos
                    (id_pedido, id_producto, precio, cantidadProductos, subtotal, observaciones, total)
                    VALUES
                    ($idPedido, $item->id_producto, $item->precio, $item->cantidadProductos, $item->subtotal, '$item->observaciones' , $item->total);";

                $vResultadoM = $this->enlace->executeSQL_DML($sql);
            }

            // Retornar el objeto creado
            return $this->get($idPedido);
        } catch (Exception $e) {
            die($e->getMessage());
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
