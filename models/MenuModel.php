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

    public function create($objeto)
    {
        try {
            // Convertir las fechas a formato "YYYY-MM-DD"
            $fechaInicio = (new DateTime($objeto->fecha_inicio))->format('Y-m-d');
            $fechaFin = (new DateTime($objeto->fecha_fin))->format('Y-m-d');

            // Convertir las horas a formato "HH:MM:SS"
            //$horaInicio = (new DateTime($objeto->hora_inicio))->format('H:i:s');
            //$horaFin = (new DateTime($objeto->hora_fin))->format('H:i:s');

            //Consulta SQL
            //Identificador autoincrementable
            $sql = "Insert into menu (nombre, fecha_inicio, fecha_fin, hora_inicio, hora_fin)" .
                " Values ('$objeto->nombre','$fechaInicio','$fechaFin','$objeto->hora_inicio','$objeto->hora_fin')";

            //Ejecutar la consulta
            //Obtener último insert
            $idmenu = $this->enlace->executeSQL_DML_last($sql);

            //--- productos ---
            //Crear elementos a insertar en Productos
            foreach ($objeto->productos as $item) {
                $sql = "Insert into menus_productos (id_menu, id_producto)" .
                    " Values($idmenu, $item)";
                $this->enlace->executeSQL_DML($sql);
            }

            //--- combos ---
            //Crear elementos a insertar en combos
            foreach ($objeto->combos as $item) {
                $sql = "Insert into menus_combos (id_menu, id_combo)" .
                    " Values($idmenu, $item)";
                $this->enlace->executeSQL_DML($sql);
            }

            //Retornar menu
            return $this->get($idmenu);
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

            // Convertir las fechas a formato "YYYY-MM-DD"
            $fechaInicio = (new DateTime($objeto->fecha_inicio))->format('Y-m-d');
            $fechaFin = (new DateTime($objeto->fecha_fin))->format('Y-m-d');


            // Consulta SQL
            // Consulta SQL
            $sql = "UPDATE menu SET 
            nombre = '$objeto->nombre', 
            fecha_inicio = '$fechaInicio', 
            fecha_fin = '$fechaFin', 
            hora_inicio = '$objeto->hora_inicio', 
            hora_fin = '$objeto->hora_fin' 
            WHERE id = $objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);

            //--- producto ---
            //Eliminar productos asociados al menu
            $sql = "Delete from menus_productos where id_menu=$objeto->id";
            $vResultadoD = $this->enlace->executeSQL_DML($sql);


             //--- productos ---
            //Crear elementos a insertar en Productos
            foreach ($objeto->productos as $item) {
                $sql = "Insert into menus_productos (id_menu, id_producto)" .
                    " Values($objeto->id, $item)";
                $this->enlace->executeSQL_DML($sql);
            }

                //--- combos ---
            //Eliminar combos asociados al menu
            $sql = "Delete from menus_combos where id_menu=$objeto->id";
            $vResultadoD = $this->enlace->executeSQL_DML($sql);

            //--- combos ---
            //Crear elementos a insertar en combos
            foreach ($objeto->combos as $item) {
                $sql = "Insert into menus_combos (id_menu, id_combo)" .
                    " Values($objeto->id, $item)";
                $this->enlace->executeSQL_DML($sql);
            }


            //Retornar producto actualizado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
