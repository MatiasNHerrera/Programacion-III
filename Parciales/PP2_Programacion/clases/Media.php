<?php

require_once "AccesoDatos.php";
require_once "AutentificadorJWT.php";

class Media
{
    public $color;
    public $marca;
    public $precio;
    public $talle;

    public static function AgregarMedia($request, $response)
    {
        $datos = $request->getParsedBody();
        $color = $datos["color"];
        $marca = $datos["marca"];
        $precio = $datos["precio"];
        $talle = $datos["talle"];

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO medias (color,marca,precio,talle) values (:color,:marca,:precio,:talle)");
        $consulta->bindValue(":color", $color);
        $consulta->bindValue(":marca", $marca);
        $consulta->bindValue(":precio", $precio);
        $consulta->bindValue(":talle", $talle);

        $consulta->execute();
        
        if($consulta->rowCount() > 0)
        {
            echo "se ha agregado exitosamente";
        }
        else
        {
            echo "no se ha podido agregar";
        }
		
    }

    public static function MostrarMedias($consulta = "SELECT * FROM medias")
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($consulta);
        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $datos;
    }

    public function TraerMedias($request, $response)
    {
        $datos = Usuario::MostrarMedias($consulta);
        return $response->withJson($datos, 200);
    }

    public function BorrarMedia($request, $response)
    {
        $token = $request->getHeader('token');
        $tokenReal = $token[0];
        $datos = AutentificadorJWT::ObtenerData($tokenReal);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM medias WHERE id = :id");
        $consulta->bindValue(':id', $datos->id);

        if($datos->perfil == "propietario")
        {   
            $consulta->execute();
        }

        if($consulta->rowCount() > 0)
        {
            echo "Se ha eliminado";
        }
        else
        {
            echo "No se ha podido eliminar, cheque";
        }
    }

    public function ModificarMedia($request, $response)
    {
        $token = $request->getHeader('token');
        $tokenReal = $token[0];
        $datos = AutentificadorJWT::ObtenerData($tokenReal);
        $consulta = null;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE medias SET color=:color, marca=:marca,precio=:precio,talle=:talle WHERE id=:id");
        $consulta->bindValue(':color', $datos->color);
        $consulta->bindValue(':marca', $datos->marca);
        $consulta->bindValue(':precio', $datos->precio);
        $consulta->bindValue(':talle', $datos->talle);
        $consulta->bindValue(':id', $datos->id);

        if(strtolower($datos->perfil) == "propietario" || strtolower($datos->perfil) == "encargado")
        {
            $consulta->execute(); 
        }

        if($consulta->rowCount() > 0)
        {
            echo "Se ha podido modificar";
        }
        else
        {
            echo "No se ha podido de modificar";
        }
    }

}