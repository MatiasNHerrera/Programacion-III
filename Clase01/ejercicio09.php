<?php

$array = array();
$suma = 0;

for($i = 0; $i < 5; $i++)
{
    array_push($array, rand(1,10));
    $suma = $suma + $array[$i];
}

$suma= $suma / 5;

echo $suma. "<br/>";

if($suma > 6)
{
    echo "Es mayor a 6";
}
else if($suma == 6)
{
    echo "Es igual a 6";
}
else
{
    echo "Es menor a 6";
}