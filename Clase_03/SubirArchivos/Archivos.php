<?php

class Archivo
{
    public static function Subir() //valida si se puede subir la imagen
    {
        $subirArchivo = TRUE;
        $destino = "./Archivos/" . $_FILES["archivo"]["name"];
        
        if(file_exists($destino))
        {
            $subirArchivo = FALSE;
            echo "ya existe el archivo, revise el path";
            echo "<br/>";
        }

        if($subirArchivo)
        {
            $validacion = false;

            if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino))
            {
                $validacion = true;
            }
        }

        return $destino;
    }
}