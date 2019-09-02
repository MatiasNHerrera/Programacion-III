<?php

include "Clases/productos.php";

$op = 'ALTA';

switch($op)
{
    case $_GET["op"]:

    $producto = new Producto($_GET["nombre"], $_GET["cod"]);

    if(Producto::Guardar($producto))
    {
        echo "Se pudo guardar";
    }

}