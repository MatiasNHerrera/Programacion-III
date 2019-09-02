<?php

$archivo = fopen("escritura.txt", "r");

/*while(!feof($archivo))
{
    $string = fgets($archivo);
}

echo "lectura con fgets <br/>";

echo "<h2>". $string. "<h2>";*/

$string = fread($archivo, filesize("escritura.txt"));

echo $string;

echo "<br/> lectura con fread";