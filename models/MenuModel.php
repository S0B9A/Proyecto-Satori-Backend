<?php
class MenuModel
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
            $vSQL = "SELECT * FROM menu ORDER BY fecha_inicio DESC;";
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
            $comboModel = new ComboModel();


            $vSql = "SELECT * FROM menu WHERE id = $id;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $menuID =  $vResultado->id;
                $productos = $productoModel->getProductosPorMenuID($menuID);
                $vResultado->productos = $productos;

                //Combos 
                $menuID =  $vResultado->id;
                $combos = $comboModel->getCombosPorMenuID($menuID);
                $vResultado->combos = $combos;

            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getMenuActual()
    {
        try {

            $productoModel = new ProductoModel();
            $comboModel = new ComboModel();


            $vSql = "SELECT * FROM menu WHERE CURDATE() BETWEEN fecha_inicio AND fecha_fin ORDER BY fecha_inicio DESC LIMIT 1;";

            //Ejecutar la consulta sql
            $vResultado = $this->enlace->executeSQL($vSql);

            if (!empty($vResultado)) {

                $vResultado = $vResultado[0];

                //Producto
                $menuID =  $vResultado->id;
                $productos = $productoModel->getProductosPorMenuID($menuID);
                $vResultado->productos = $productos;

                //Combos 
                $menuID =  $vResultado->id;
                $combos = $comboModel->getCombosPorMenuID($menuID);
                $vResultado->combos = $combos;

            }

            //Retornar la respuesta
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
