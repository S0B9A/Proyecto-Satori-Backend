<?php

//http://localhost:81/SatoriAsianCuisine/imagenCombo

class imagenCombo
{
    //Post 
    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputFILE = $request->getBody();

            //Instancia del modelo
            $imagenModelCombo = new ImagenModelCombo();

            //Acción del modelo a ejecutar
            $resultImagen = $imagenModelCombo->uploadFile($inputFILE);

            //Dar respuesta
            $response->toJSON($resultImagen);

        } catch (Exception $e) {
            handleException($e);
        }
    }
}
