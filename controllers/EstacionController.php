<?php

//http://localhost:81/SatoriAsianCuisine/estacion

class estacion
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $estacionModel = new EstacionModel;

            //Método del modelo
            $result = $estacionModel->all();

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
            $estacion = new EstacionModel;
            $result = $estacion->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getEstacionesPorProductoID($param)
    {
        try {
            $response = new Response();
            $estacion = new EstacionModel;
            $result = $estacion->getEstacionesPorProductoID($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
