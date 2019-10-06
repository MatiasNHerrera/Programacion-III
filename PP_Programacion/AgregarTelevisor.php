<?php
    require_once "clases/Televisor.php";

    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;

    $television = new Televisor($tipo,$precio,$paisOrigen,$nombreFoto);
    $json = new stdClass();
    $foto = $tipo . "." . $paisOrigen. "." . date("H-i-s") . ".jpg";
    $destino = "./televisores/imagenes/". $foto;
    $json->exito = false;
    $json->mensaje = "No se ha podido agregar";

    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
    {
        if($television->Agregar())
        {
            $json->exito = true;
            $json->mensaje = "Se agrego correctamente";
            header("location: Listado.php");
        }
    }
    
    json_encode($json);
    