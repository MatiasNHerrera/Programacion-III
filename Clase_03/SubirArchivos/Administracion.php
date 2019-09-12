<?php
session_start();
include "productos.php";
include "Archivos.php";

$op = "op";

switch($op)
{
    case "op":

    $producto = new Producto($_POST["nombre"],$_POST["codigo"],Archivo::Subir());

    if(Producto::Guardar($producto))
    {
       echo "Se pudo guardar";
       $_SESSION["clave"] = $producto->cod_barra;
    }
    else
    {
        echo "No se ha podido guardar con exito";
    }

    var_dump($_SESSION);
    
}

