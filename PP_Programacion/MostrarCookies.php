<?php

$email = isset($_GET["email"]) ? $_GET["email"] : null;
$aux = new stdClass();

$modificado = str_replace(".", "_", $email);

if(isset($_COOKIE[$modificado]))
{
    $aux->existe = true;
    $aux->mensaje = $_COOKIE[$modificado];
}
else
{
    $aux->existe = false;
    $aux->mensaje = "No se encuentra seteada la cookie";
}

echo json_encode($aux);