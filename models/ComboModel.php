<?php
class ComboModel
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
            $vSQL = "SELECT * FROM combo ORDER BY nombre DESC;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSQL);
            //Retornar la respuesta

            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }


    public function get($id)
    {
        try {

            $productoModel = new ProductoModel();


            $vSql = "SELECT * FROM combo WHERE id = $id;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $comboID =  $vResultado->id;
                $productos = $productoModel->getProductosPorComboID($comboID);
                $vResultado->productos = $productos;
            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

       /*Obtener Todos los combos que forman parte del menu por su id */
       public function getCombosPorMenuID($id)
       {
           try {
               //Consulta sql
               $vSql = "SELECT * FROM combo WHERE id IN (SELECT id_combo FROM menus_productos WHERE id_menu = $id);";
   
               //Ejecutar la consulta
               $vResultado = $this->enlace->ExecuteSQL($vSql);
               // Retornar la lista
               return $vResultado;
           } catch (Exception $e) {
               handleException($e);
           }
       }
}
