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

    //POST Crear
    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputJSON = $request->getJSON();

            //Instancia del modelo
            $comboModel = new ComboModel();

            //Acción del modelo a ejecutar
            $result = $comboModel->create($inputJSON);

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
            $comboModel = new ComboModel();

            //Acción del modelo a ejecutar
            $result = $comboModel->update($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
