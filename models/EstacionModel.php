<?php
class EstacionModel
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
            $productoModel = new ProductoModel();

            // Consulta SQL
            $vSQL = "SELECT * FROM estacion;";

            // Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSQL);

            // Si hay resultados
            if (!empty($vResultado)) {
                // Recorrer cada estación
                foreach ($vResultado as $estacion) {
                    // Obtener el ID de la estación
                    $estacionID = $estacion->id;
                    // Obtener los productos asociados a esa estación
                    $productos = $productoModel->getProductosPorEstacionID($estacionID);
                    // Asignar los productos a la estación actual
                    $estacion->productos = $productos;
                }
                
            }

            // Retornar la lista de estaciones con sus productos
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($id)
    {
        try {

            $productoModel = new ProductoModel();

            $vSql = "SELECT * FROM estacion WHERE id = $id;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $estacionID =  $vResultado->id;
                $productos = $productoModel->getProductosPorEstacionID($estacionID);
                $vResultado->productos = $productos;
            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    //
    public function getEstacionesPorProductoID($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM estacion WHERE id IN ( SELECT id_estacion FROM estaciones_productos  WHERE id_producto = $id)
             ORDER BY (SELECT orden FROM estaciones_productos WHERE id_estacion = estacion.id AND id_producto = $id) desc;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getCantidadEstacionesPorProductoID($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT COUNT(id_estacion) AS total_estaciones FROM estaciones_productos  WHERE id_producto = $id;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado[0];
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
