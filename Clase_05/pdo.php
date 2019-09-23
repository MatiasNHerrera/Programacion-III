<?php

$user = "root";
$pass = "";

try
{
    $pdo = new PDO("mysql:host=localhost;dbname=cdcol;charset=utf8", $user, $pass);
    echo "Se ha realizado la conexion correctamente";

    $exito = $pdo->query("SELECT * FROM cds");

    foreach($exito->fetchAll() as $fila)
    {
        echo "</br>Titulo: ". $fila[0]. " - Interprete: ". $fila[1]. " - Año: ". $fila[2];
    }
    

}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}