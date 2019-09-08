<?php

include "Clases/productos.php";

$op = "MOSTRAR";

switch($op)
{
    case "op":

    $producto = new Producto($_GET["nombre"], $_GET["cod"]);

    if(Producto::Guardar($producto))
    {
        echo "Se pudo guardar";
    }

    case "MOSTRAR":

    var_dump(Producto::TraerTodosLosProductos());

}

