<?php
class UsuarioModel
{
    public $enlace;
    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM usuario;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {

        try {

            //Consulta sql
            $vSql = "SELECT * FROM usuario where id=$id";

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
}
