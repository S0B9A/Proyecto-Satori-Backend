<?php

// http://localhost:81/SatoriAsianCuisine/producto
class producto
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $productoModel = new ProductoModel;

            //Método del modelo
            $result = $productoModel->all();
            
            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
