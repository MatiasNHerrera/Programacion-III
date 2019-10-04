<?php

class Archivo
{
    public static function SubirArchivo()
    {
        $destino = "../fotos/" . date("d-m-y") . ".jpg";
        $retorno["Exito"] =  TRUE;
        $retorno["foto"] = "./fotos/" . date("d-m-y") . ".jpg";

		if ($_FILES["archivo"]["size"] > 1000000) {
			$retorno["Exito"] = FALSE;
			$retorno["Mensaje"] = "El archivo es demasiado grande.\nVerifique!!!";
			return $retorno;
		}

		//OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
		//IMAGEN, RETORNA FALSE
		$esImagen = getimagesize($_FILES["archivo"]["tmp_name"]);

		if($esImagen === FALSE) {//NO ES UNA IMAGEN
			$retorno["Exito"] = FALSE;
			$retorno["Mensaje"] = "Solo son permitidas IMAGENES.";
			return $retorno;
        }
        
        if(!move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino))
        {
            $retorno["Exito"] = FALSE;
        }

        return $retorno;
    }
}