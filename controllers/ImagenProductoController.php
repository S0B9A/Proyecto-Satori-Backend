<?php

//http://localhost:81/SatoriAsianCuisine/imagenProducto

class imagenProducto
{
    //POST Crear
    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputFILE = $request->getBody();

            //Instancia del modelo
            $imagenModelProducto = new ImagenModelProducto();

            //Acción del modelo a ejecutar
            $resultImagen = $imagenModelProducto->uploadFile($inputFILE);

            //Dar respuesta
            $response->toJSON($resultImagen);

        } catch (Exception $e) {
            handleException($e);
        }
    }
}
