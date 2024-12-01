<?php

//http://localhost:81/SatoriAsianCuisine/cocina

class cocina
{
    public function get($param)
    {
        try {
            $response = new Response();
            $cocina = new CocinaModel();
            $result = $cocina->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getListaDeProductosPorPedido($param)
    {
        try {
            $response = new Response();
            $cocina = new CocinaModel();
            $result = $cocina->getListaDeProductosPorPedido($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    //PUT actualizar
    public function update()
    {
        try {

            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputJSON = $request->getJSON();

            //Instancia del modelo
            $cocina = new CocinaModel();

            //Acción del modelo a ejecutar
            $result = $cocina->update($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
