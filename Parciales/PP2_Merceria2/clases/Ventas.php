<?php

class Ventas
{
    public static function AgregarVenta($request, $response)
    {
        $datos = $request->getParsedBody();
        $idUsuario = $datos["id_usuario"];
        $idMedia = $datos["id_media"];
        $cantidad = $datos["cantidad"];
        $json = new stdClass();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO venta_medias (id_usuario,id_medias,cantidad) values (:id_usuario,:id_media,:cantidad)");
        $consulta->bindValue(":id_usuario", $idUsuario);
        $consulta->bindValue(":id_media", $idMedia);
        $consulta->bindValue(":cantidad", $cantidad);

        $consulta->execute();
        
        if($consulta->rowCount() > 0)
        {
            $json->mensaje = "Se ha agregado correctamente";
            $nuevaRespuesta = $response->withJson($json, 200);
        }
        else
        {
            $json->mensaje = "No se ha podido agregar";
            $nuevaRespuesta = $response->withJson($json, 200);
        }

        return $nuevaRespuesta;
		
    }

    public static function MostrarVentas($request, $response)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id_usuario, id_medias, cantidad from venta_medias");
        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_OBJ);
        
        $nuevaRespuesta = $response->withJson($datos, 200);

        return $nuevaRespuesta;
    }

    public function BorrarVenta($request, $response)
    {
        $data = $request->getParsedBody();
        $id_usuario = $data["id_usuario"];
        $id_media = $data["id_media"];
        $perfil = $data["perfil"];
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM venta_medias WHERE id_usuario = :id_usuario AND id_medias = :id_media");
        $consulta->bindValue(':id_usuario', $id_usuario);
        $consulta->bindValue(':id_media', $id_media);
        $consulta->execute();
        
        if($consulta->rowCount() > 0)
        {
            echo "Se ha eliminado";
        }
        else
        {
            echo "No se ha podido eliminar, cheque";
        }
    }

    public function ModificarVenta($request, $response)
    {
        $datos = $request->getParsedBody();
        $cantidad = $datos["cantidad"];
        $id = $datos["id"];
        $perfil = $datos["perfil"];

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE venta_medias SET cantidad=:cantidad WHERE id=:id");
        $consulta->bindValue(':cantidad', $cantidad);
        $consulta->bindValue(':id', $id);
        $consulta->execute(); 
        
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