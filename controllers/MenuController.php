<?php

//http://localhost:81/SatoriAsianCuisine/menu

class menu
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $menuModel = new MenuModel;

            //Método del modelo
            $result = $menuModel->all();

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
            $menu = new MenuModel;
            $result = $menu->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    //GET listar
    public function getMenuActual()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $menuModel = new MenuModel;

            //Método del modelo
            $result = $menuModel->getMenuActual();

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
            $menuModel = new MenuModel;

            //Acción del modelo a ejecutar
            $result = $menuModel->create($inputJSON);

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
             $menuModel = new MenuModel;

             //Acción del modelo a ejecutar
             $result = $menuModel->update($inputJSON);
 
             //Dar respuesta
             $response->toJSON($result);
         } catch (Exception $e) {
             handleException($e);
         }
     }
}
