<?php

$archivo = fopen("escritura.txt", "a");
$cad = fwrite($archivo, $_GET["Nombre"]);
$cad = fwrite($archivo, "\n\r");

if($cad > 0)
{
    echo "escritura exitosa<br/>";
}



fclose($archivo);

