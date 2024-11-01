<?php

//http://localhost:81/SatoriAsianCuisine/producto

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

    public function get($param)
    {
        try {
            $response = new Response();
            $producto = new ProductoModel;
            $result = $producto->get($param);

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
            $productoModel = new ProductoModel();

            //Acción del modelo a ejecutar
            $result = $productoModel->create($inputJSON);

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
             $productoModel = new ProductoModel();

            //Acción del modelo a ejecutar
            $result = $productoModel->update($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
