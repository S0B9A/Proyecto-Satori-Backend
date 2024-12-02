<?php

//http://localhost:81/SatoriAsianCuisine/ingrediente

class ingrediente
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $ingredienteModel = new IngredienteModel();

            //Método del modelo
            $result = $ingredienteModel->all();

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

}
