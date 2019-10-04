<?php

require_once "archivo.php";

$queHago = isset($_POST["queHago"]) ? $_POST["queHago"] : null;

switch($queHago)
{
    case "1": 
    
    $validacion = Archivo::SubirArchivo();

    if($validacion["Exito"])
    {
        $mensaje = $_POST["mensaje"];

        $obj = new stdClass();

        $obj->mensaje = $mensaje;

        $obj->fecha = date("d-m-y");

        $obj->foto = $validacion["foto"];

        echo json_encode($obj);
    }
    

}