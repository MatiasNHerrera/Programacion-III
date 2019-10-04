<?php
session_start();
require_once "vendor/autoload.php";
require_once "Clases/usuario.php";
require_once "Clases/producto.php";

$mpdf = new \Mpdf\Mpdf();
$usuarios = Usuario::TraerTodosUsuarios();
$productos = Producto::TraerTodosLosProductos();

if(isset($_SESSION["perfil"]) && $_SESSION["perfil"] == 1)
    {
        foreach($usuarios as $datitos)
        {
            $mpdf->WriteHTML($datitos->nombre . " - ".  $datitos->apellido . " - " . $datitos->perfil. " - " . $datitos->estado. " - " . $datitos->correo . " - " . "<img src='" . $datitos->foto. "' width='100px' heigth='100px'> ");
        }

        foreach($productos as $datitos)
        {
            $mpdf->WriteHTML($datitos->toString() . "<img src='archivos/". $datitos->GetPathFoto(). "' width='50'>");
        }
    }
else if(isset($_SESSION["perfil"]) && $_SESSION["perfil"] == 2)
{
    foreach($productos as $datitos)
    {
        $mpdf->WriteHTML($datitos->toString());
    }
}
else
{
    header("location: login.php");
}

$mpdf->Output();