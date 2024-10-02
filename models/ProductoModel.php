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
             //Consulta sql
             $vSql = "SELECT * FROM producto WHERE id IN (SELECT id_producto FROM estaciones_productos WHERE id_estacion = $id);";
 
             //Ejecutar la consulta
             $vResultado = $this->enlace->ExecuteSQL($vSql);
             // Retornar la lista
             return $vResultado;
         } catch (Exception $e) {
             handleException($e);
         }
     }
}
