<?php
class ProductoModel
{
    //Conectarse a la BD
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    /**
     * Listar productos
     * @param 
     * @return $vResultado - Lista de objetos
     */

    public function all()
    {
        try {
            $estacionModel = new EstacionModel();
            //Consulta SQL
            $vSQL = "SELECT * FROM producto ORDER BY nombre DESC;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSQL);
            //Retornar la respuesta

            if (!empty($vResultado)) {
                // Asumiendo que $vResultado es un array de objetos
                for ($i = 0; $i < count($vResultado); $i++) {
                    // Obtén el ID del producto
                    $productoID = $vResultado[$i]->id;
            
                    // Obtén la cantidad de estaciones para el producto
                    $estaciones = $estacionModel->getCantidadEstacionesPorProductoID($productoID);
            
                    // Asigna la cantidad de estaciones al objeto en la posición $i
                    $vResultado[$i]->CantidadEstaciones = $estaciones;
                }
            }

            
            
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /*Obtener Producto por id */
    public function get($id)
    {
        try {

            $estacionModel = new EstacionModel();

            //Consulta sql
            $vSql = "SELECT * fROM producto where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $productoID =  $vResultado->id;
                $estaciones = $estacionModel->getEstacionesPorProductoID($productoID);
                $vResultado->estaciones = $estaciones;
            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /*Obtener Producto por id */
    public function getProductoDetalleProceso($id)
    {
        try {

            $estacionModel = new EstacionModel();

            //Consulta sql
            $vSql = "SELECT * fROM producto where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $productoID =  $vResultado->id;
                $estaciones = $estacionModel->getEstacionesPorProductoID($productoID);
                $vResultado->estaciones = $estaciones;

            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /*Obtener Todos los Producto que son del combo por su id */
    public function getProductosPorComboID($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM producto WHERE id IN (SELECT id_producto FROM combos_productos WHERE id_combo = $id);";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /*Obtener Todos los Producto que forman parte del menu por su id */
    public function getProductosPorMenuID($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM producto WHERE id IN (SELECT id_producto FROM menus_productos WHERE id_menu = $id);";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /*Obtener Todos los Producto que forman parte del estacionProducto por su id */
    public function getProductosPorEstacionID($id)
    {
        try {
            $estacionModel = new EstacionModel();

            //Consulta sql
            $vSql = "SELECT * FROM producto WHERE id IN (SELECT id_producto FROM estaciones_productos WHERE id_estacion = $id) ;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);


            if (!empty($vResultado)) {

                foreach ($vResultado as $producto) {
                    // Obtener el ID de la estación
                    $productoID = $producto->id;
                    // Obtener los productos asociados a esa estación
                    $cantidadEstaciones = $estacionModel->getCantidadEstacionesPorProductoID($productoID);
                    // Asignar los productos a la estación actual
                    $producto->cantidadEstaciones = $cantidadEstaciones;
                }
            }

            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /**
     * Crear producto
     * @param $objeto Producto a insertar
     * @return $this->get($idProducto) - Objeto Producto
     */
    //
    public function create($objeto)
    {
        try {
            $contador = 1;

            //Consulta sql
            //Identificador autoincrementable
            $sql = "Insert into producto (nombre, descripcion, precio, tipo, categoria, imagen)" .
                " Values ('$objeto->nombre','$objeto->descripcion',$objeto->precio,'$objeto->tipo','$objeto->categoria','noImagen.png')";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idproducto = $this->enlace->executeSQL_DML_last($sql);

            //--- estaciones ---
            //Crear elementos a insertar en estacionesProducto
            foreach ($objeto->estaciones as $item) {

                $sql = "Insert into estaciones_productos (id_estacion, id_producto, orden)" .
                    " Values($item, $idproducto, $contador)";

                $vResultadoG = $this->enlace->executeSQL_DML($sql);

                $contador++;
            }

            //Retornar Producto
            return $this->get($idproducto);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /**
     * Actualizar producto
     * @param $objeto producto a actualizar
     * @return $this->get($idproducto) - Objeto producto
     */
    //
    public function update($objeto)
    {
        try {
            $contador = 1;

            // Consulta SQL
            $sql = "UPDATE producto SET 
                    nombre = '$objeto->nombre',
                    descripcion = '$objeto->descripcion',
                    precio = $objeto->precio,
                    tipo = '$objeto->tipo',
                    categoria = '$objeto->categoria'
                    WHERE id = $objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);

            //--- Estaciones ---
            //Eliminar estaciones asociados al producto
            $sql = "Delete from estaciones_productos where id_producto=$objeto->id";
            $vResultadoD = $this->enlace->executeSQL_DML($sql);


            //Crear elementos a insertar en estacionesProducto
            foreach ($objeto->estaciones as $item) {
                

                $sql = "Insert into estaciones_productos (id_estacion, id_producto, orden)" .
                    " Values($item, $objeto->id, $contador)";

                $vResultadoG = $this->enlace->executeSQL_DML($sql);

                $contador++;
            }


            //Retornar producto actualizado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
