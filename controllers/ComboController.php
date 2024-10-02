<?php

//http://localhost:81/SatoriAsianCuisine/combo

class combo
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $comboModel = new comboModel;

            //Método del modelo
            $result = $comboModel->all();

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $combo = new ComboModel;
            $result = $combo->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
