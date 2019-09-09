<?php

include "productos.php";
include "Archivos.php";

$op = "MOSTRAR";

switch($op)
{
    case "op":

    $producto = new Producto("tomas",126,Archivo::Subir());

    if(Producto::Guardar($producto))
    {
        echo "Se pudo guardar";
    }

    case "MOSTRAR":

    $array = Producto::TraerTodosLosProductos();
    $destino = Archivo::Subir();
    for($i = 0; $i < count($array); $i++)
    {   
        echo "<br/>";
        echo ($array[$i]->toString());
        echo "<img src='$destino' width='10%'";
        echo "<br/>";
    }
        
    
}

