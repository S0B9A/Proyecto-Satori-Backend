<?php

//http://localhost:81/SatoriAsianCuisine/pedido

class pedido
{
    //GET listar
    public function index()
    {
        try {
            $response = new Response();

            //Instancia modelo
            $pedidoModel = new PedidoModel();

            //Método del modelo
            $result = $pedidoModel->all();

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    //GET listar pedidos por usuario
    public function PedidosPorUsuario($param)
    {
        try {
            $response = new Response();

            //Instancia modelo
            $pedidoModel = new PedidoModel();

            //Método del modelo
            $result = $pedidoModel->PedidosPorUsuarioID($param);

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
            $pedidoModel = new PedidoModel();
            $result = $pedidoModel->get($param);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getPedidoMasReciente()
    {
        try {
            $response = new Response();
            $pedidoModel = new PedidoModel();
            $result = $pedidoModel->getPedidoMasReciente();

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
            $pedidoModel = new PedidoModel();

            //Acción del modelo a ejecutar
            $result = $pedidoModel->create($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }



    //PUT Pago de pedido
    public function updatePedidoPorPago()
    {
        try {

            $request = new Request();
            $response = new Response();

            //Obtener json enviado
            $inputJSON = $request->getJSON();

            //Instancia del modelo
            $pedidoModel = new PedidoModel();

            //Acción del modelo a ejecutar
            $result = $pedidoModel->updatePedidoPorPago($inputJSON);

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
            $pedidoModel = new PedidoModel();

            //Acción del modelo a ejecutar
            $result = $pedidoModel->update($inputJSON);

            //Dar respuesta
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
