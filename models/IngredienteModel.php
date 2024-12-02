<?php
class IngredienteModel
{
    //Conectarse a la BD
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all(){
        try {
            //Consulta sql
			$vSql = "SELECT * FROM ingrediente;";
			
            //Ejecutar la consulta
			$vResultado = $this->enlace->ExecuteSQL ( $vSql);
				
			// Retornar el objeto
			return $vResultado;
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }

    public function getIngredientePorProductoID($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM ingrediente WHERE id IN ( SELECT id_ingrediente FROM producto_ingrediente  WHERE id_producto = $id)";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar la lista
            return $vResultado;
        } catch (Exception $e) {
            handleException($e);
        }
    }
}

  
