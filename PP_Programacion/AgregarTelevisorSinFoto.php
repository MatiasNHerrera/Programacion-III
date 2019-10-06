<?php
require_once "clases/Televisor.php";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;
$televisor = new Televisor($tipo,$precio,$paisOrigen);

$json = new stdClass();

if($televisor->Agregar())
{
    $json->exito = true;
    $json->mensaje = "se ha guardado con exito";
    echo json_encode($json);
}
else
{
    $json->exito = false;
    $json->mensaje = "no se ha podido guardar";
    echo json_encode($json);
}