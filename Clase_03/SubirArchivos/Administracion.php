<?php

include "productos.php";
include "Archivos.php";

$op = "op";

switch($op)
{
    case "op":

    $producto = new Producto("matias", 123, "/Archivos/Chrysanthemum.jpg");

    if(Producto::Guardar($producto))
    {
        echo "Se pudo guardar";
    }

    case "MOSTRAR":

    $array = Producto::TraerTodosLosProductos();

    /*for($i = 0; $i < count($array); $i++)
        {
            echo ($array[0]->toString());
            //echo "<img src="$array[$i]->path">";
        }
        */
    
}

