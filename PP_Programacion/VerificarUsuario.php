<?php
require_once "clases/Usuario.php";
date_default_timezone_set("America/Argentina/Buenos_Aires");
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : null;

$usuario = new Usuario($email, $clave);

if(Usuario::VerificarExistencia($usuario))
{
    setcookie($_POST["email"],date("d-m-y") . " - ". date("H:i:s"));
    header("location: ListadoUsuarios.php");
}
else
{
    $retorno = new stdClass();
    $retorno->exito=false;
    $retorno->mensaje="El usuario no existe";
    echo json_encode($retorno);
}
