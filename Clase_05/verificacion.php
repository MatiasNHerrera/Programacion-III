<?php
session_start();
include_once "./Clases/usuario.php";

$queHago = isset($_POST["queHago"]) ? $_POST["queHago"] : null;

switch($queHago)
{
    case "validar": 

    $Json = isset($_POST["datos"]) ? $_POST["datos"] : null;

    $datos = json_decode($_POST["informacion"]);
    
    $validacion = Usuario::validarBD($datos->correo, $datos->clave);

    if($validacion->existe == true)
    {
        foreach($validacion->user as $datitos)
        {
            $_SESSION["perfil"] = $datitos->perfil;
        }
        
    }
    else
    {
        echo "los datos no se encuentran en la tabla";
    }

    echo json_encode($validacion);
    break;

    case "registrar":

    $datos = json_decode($_POST["usuario"]);

    $usuario = new Usuario($datos);

    if($usuario->InsertarUsuario())
    {
        echo "Se ha agregado exitosamente";
    }
    else
    {
        echo "Ya existe ese usuario, no se ha podido registrar";
    }
    
}
