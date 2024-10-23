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
            //Consulta SQL
            $vSQL = "SELECT * FROM producto ORDER BY nombre DESC;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSQL);
            //Retornar la respuesta

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

                //Ordenes

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
     * Crear pelicula
     * @param $objeto pelicula a insertar
     * @return $this->get($idMovie) - Objeto pelicula
     */
    //
    public function create($objeto)
    {
        try {
            //Consulta sql
            //Identificador autoincrementable
            $sql = "Insert into producto (nombre, descripcion, precio, tipo, categoria)" .
                " Values ('$objeto->nombre','$objeto->descripcion',$objeto->precio,'$objeto->tipo','$objeto->categoria')";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idproducto = $this->enlace->executeSQL_DML_last($sql);

            //--- Generos ---
            //Crear elementos a insertar en estacionesProducto
            foreach ($objeto->estaciones as $item) {

                $sql = "Insert into estaciones_productos (id_estacion, id_producto)" .
                    " Values($item, $idproducto)";

                $vResultadoG = $this->enlace->executeSQL_DML($sql);
            }

            //Retornar pelicula
            return $this->get($idproducto);
        } catch (Exception $e) {
            handleException($e);
        }
    }


    /**
     * Actualizar prodcuto
     * @param $objeto producto a actualizar
     * @return $this->get($idproducto) - Objeto producto
     */
    //
    public function update($objeto)
    {
        try {
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
