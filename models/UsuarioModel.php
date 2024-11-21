<?php

use Firebase\JWT\JWT;

class UsuarioModel
{
    public $enlace;
    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM usuario;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function allClientes()
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM usuario WHERE rol_id = 2;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {
        try {

            $rolModelo = new RolModel();

            //Consulta sql
            $vSql = "SELECT * FROM usuario where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if ($vResultado) {
                $vResultado = $vResultado[0];

                //Asignar rol
                $rol = $rolModelo->getRolUsuario($id);
                $vResultado->rol = $rol;

                // Retornar el objeto
                return $vResultado;
            } else {
                return null;
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function login($objeto)
    {
        try {

            $vSql = "SELECT * from usuario where email='$objeto->email'";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if (is_object($vResultado[0])) {

                $usuario = $vResultado[0];

                if (password_verify($objeto->contraseña, $usuario->contraseña)) {
                    $usuario = $this->get($usuario->id);

                    if (!empty($usuario)) {
                        // Datos para el token JWT
                        $data = [
                            'id' => $usuario->id,
                            'email' => $usuario->email,
                            'rol' => $usuario->rol,
                            'iat' => time(),  // Hora de emisión
                            'exp' => time() + 3600 // Expiración en 1 hora
                        ];

                        // Generar el token JWT
                        $jwt_token = JWT::encode($data, config::get('SECRET_KEY'), 'HS256');

                        // Enviar el token como respuesta
                        return $jwt_token;
                    }
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create($objeto)
    {
        try {
            if (isset($objeto->contraseña) && $objeto->contraseña != null) {
                $crypt = password_hash($objeto->contraseña, PASSWORD_BCRYPT);
                $objeto->contraseña = $crypt;
            }

            //Consulta sql            
            $vSql = "Insert into usuario (nombre,email,contraseña,rol_id)" .
                " Values ('$objeto->nombre','$objeto->email','$objeto->contraseña',$objeto->rol_id)";

            //Ejecutar la consulta
            $vResultado = $this->enlace->executeSQL_DML_last($vSql);

            // Retornar el objeto creado
            return $this->get($vResultado);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}
