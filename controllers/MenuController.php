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


}
