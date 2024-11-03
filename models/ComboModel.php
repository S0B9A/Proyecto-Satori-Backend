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
            $vSql = "SELECT * FROM combo WHERE id IN (SELECT id_combo FROM menus_combos WHERE id_menu = $id);";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /**
     * Crear Combo
     * @param $objeto combo a insertar
     * @return $this->get($idCombo) - Objeto Combo
     */
    //
    public function create($objeto)
    {
        try {

            //Consulta sql
            //Identificador autoincrementable
            $sql = "Insert into combo (nombre, descripcion, precio, categoria, imagen)" .
                " Values ('$objeto->nombre','$objeto->descripcion',$objeto->precio,'$objeto->categoria','noImagen.png')";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idcombo = $this->enlace->executeSQL_DML_last($sql);

            //--- Producto ---
            //Crear elementos a insertar en CombosProducto
            foreach ($objeto->productos as $item) {

                $sql = "Insert into combos_productos (id_combo, id_producto)" .
                    " Values($idcombo, $item)";

                $vResultadoG = $this->enlace->executeSQL_DML($sql);
            }

            //Retornar combo
            return $this->get($idcombo);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    /**
     * Actualizar combo
     * @param $objeto combo a actualizar
     * @return $this->get($idcombo) - Objeto combo
     */
    //
    public function update($objeto)
    {
        try {

            // Consulta SQL
            $sql = "UPDATE combo SET 
                    nombre = '$objeto->nombre',
                    descripcion = '$objeto->descripcion',
                    precio = $objeto->precio,
                    categoria = '$objeto->categoria'
                    WHERE id = $objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);

            //--- Producto ---
            //Eliminar estaciones asociados al producto
            $sql = "Delete from combos_productos where id_combo=$objeto->id";
            $vResultadoD = $this->enlace->executeSQL_DML($sql);


            //--- Producto ---
            //Crear elementos a insertar en CombosProducto
            foreach ($objeto->productos as $item) {

                $sql = "Insert into combos_productos (id_combo, id_producto)" .
                    " Values($objeto->id, $item)";

                $vResultadoG = $this->enlace->executeSQL_DML($sql);
            }

            //Retornar combo actualizado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
