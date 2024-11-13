<?php

//http://localhost:81/SatoriAsianCuisine/usuario

class usuario
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $usuarioModel = new UsuarioModel();

            //Método del modelo
            $result = $usuarioModel->all();

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
            $usuarioModel = new UsuarioModel();
            $result = $usuarioModel->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function login()
    {
        $response = new Response();
        $request = new Request();

        //Obtener json enviado
        $inputJSON = $request->getJSON();

        $usuario = new UsuarioModel();
        $result = $usuario->login($inputJSON);

        if (isset($result) && !empty($result) && $result != false) {
            $response->toJSON($result);
        } else {
            $response->toJSON($response, "Usuario no valido");
        }
    }

    public function create()
    {
        $response = new Response();
        $request = new Request();

        //Obtener json enviado
        $inputJSON = $request->getJSON();

        $usuario = new UsuarioModel();
        $result = $usuario->create($inputJSON);
        
        //Dar respuesta
        $response->toJSON($result);
    }
}
