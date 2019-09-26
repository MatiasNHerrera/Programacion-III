<?php

include_once "./Clases/usuario.php";

$Json = isset($_POST["datos"]) ? $_POST["datos"] : null;

$datos = json_decode($Json);

$validacion = Usuario::validarBD($datos->correo, $datos->clave);

if($validacion->validacion == true)
{
    echo json_encode($datos);
    echo "-----Los datos se encuentran";
}
else
{
    echo "los datos no se encuentran en la tabla";
}