<?php

//localhost:81/apimovie/prueba
class prueba{

    public function index(){
        echo "Mensaje\n";
        $nombre = "Sebastian Arias";
        $result = "El nombre es: $nombre\n";
        $result2 = 'El nombre es: $nombre';
        echo $result;
        print ($result2);

        $array = array(); //$array=[];
        $array ["Nombre"] = "Arias";
        $array ["Edad"] = 20;
        $array ["Tags"] = array("php","web","dev");

        $array ["Contacto"] = 
        array(
            "Sitio" => "Ariasdev.com",
            "Direccion" => NULL
        );

        $response = new response();
        $response -> toJSON($array);

        
    }
}

?>