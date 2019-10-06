<?php

require_once "clases/Usuario.php";

$email = isset($_POST["email"]) ? $_POST["email"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;

$usuario = new Usuario($email, $clave);

$validacion = json_decode($usuario->GuardarEnArchivo());

if($validacion->exito)
{
    echo $validacion->mensaje;
}
else
{
    echo $validacion->mensaje;
}
