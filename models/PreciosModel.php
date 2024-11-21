<?php
class PreciosModel
{
    //Conectarse a la BD
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }


    public function get($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT * FROM Precios where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if ($vResultado) {
                $vResultado = $vResultado[0];

                // Retornar el objeto
                return $vResultado;
            } else {
                return null;
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*Obtener Todos los precios que tienen la misma cantidad */
    public function getPreciosPorCantidad($Cantidad)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM Precios WHERE cantidad IN (SELECT cantidad FROM Precios WHERE cantidad = $Cantidad);";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /**
     * Crear Precios
     * @param $objeto precio a insertar
     * @return $this->create($precio) - Objeto precio
     */
    //
    public function create($objeto)
    {
        try {

            $Cantidad = 0;
            $Combo = new ComboModel();
            $ComboObtenido = $Combo->get($objeto->id_combo);

            //--- Producto ---
            //Obtener cantidad de productos
            foreach ($ComboObtenido->productos as $item) {
                $Cantidad++;
            }

            // --- Precio por cantidad y precio del combo

            $PrecioTotal = $Cantidad  *   $ComboObtenido->precio;

            //Consulta sql
            //Identificador autoincrementable
            $sql = "Insert into Precios (id_combo, cantidad, precio)" .
                " Values ('$objeto->id_combo','$Cantidad',$PrecioTotal)";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idPrecio = $this->enlace->executeSQL_DML_last($sql);


            //Retornar precio
            return $this->get($idPrecio);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
