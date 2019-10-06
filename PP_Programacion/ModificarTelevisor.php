<?php
    require_once "clases/Televisor.php";

    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
    $paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;
    $path = isset($_POST["foto"]) ? $_POST["foto"] : null;

    $foto = $tipo . "." . $paisOrigen. "." . date("H-i-s") . ".jpg";
    $televisor = new Televisor($tipo,$precio,$paisOrigen,$foto);
    $json = new stdClass();
    $destino = "./televisores/imagenes/". $foto;
    $json->exito = false;
    $json->mensaje = "No se ha podido modificar";

    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
    {
        if($televisor->Modificar($id))
        {
            $json->exito = true;
            $json->mensaje = "Se modifico correctamente";
            header("location: Listado.php");
        }
    }
    
    json_encode($json);
    