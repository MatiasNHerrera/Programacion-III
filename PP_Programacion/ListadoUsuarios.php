<?php
require_once "clases/Usuario.php";

$datos = Usuario::TraerTodos();
$mostrar = " ";

foreach($datos as $datitos)
{
    $mostrar .= $datitos->toJSON() . "</br>";
}

echo $mostrar;