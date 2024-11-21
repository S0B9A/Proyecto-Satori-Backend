<?php

//http://localhost:81/SatoriAsianCuisine/precios

class precios
{
    public function get($param)
    {
        try {
            $response = new Response();
            $precios = new PreciosModel();
            $result = $precios->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

      //GET listar precios por cantidad
      public function PreciosPorCantidad($param)
      {
          try {
              $response = new Response();
  
              //Instancia modelo
              $precios = new PreciosModel();
  
              //Método del modelo
              $result = $precios->getPreciosPorCantidad($param);
  
              //Dar respuesta
              $response->toJSON($result);
          } catch (Exception $e) {
              handleException($e);
          }
      }

    //POST Crear
    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputJSON = $request->getJSON();

              //Instancia modelo
              $precios = new PreciosModel();

            //Acción del modelo a ejecutar
            $result = $precios->create($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
