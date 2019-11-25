<?php

require_once "AccesoDatos.php";
require_once "AutentificadorJWT.php";

class Usuario
{
    public static function AgregarUsuario($request, $response)
    {
        $datos = $request->getParsedBody();
        $foto = $request->getUploadedFiles();
        $path = $foto['foto']->getClientFilename();
        $extension = explode(".", $path);
        $nombreFoto = date("d-m-y") . ".".$extension[1];
        $correo = $datos["correo"];
        $clave = $datos["clave"];
        $nombre = $datos["nombre"];
        $apellido = $datos["apellido"];
        $perfil = $datos["perfil"];
        $destino = "./fotos/" . $nombreFoto;
        $foto['foto']->moveTo($destino);

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,apellido,perfil,foto) values (:correo,:clave,:nombre,:apellido,:perfil,:foto)");
        $consulta->bindValue(":correo", $correo);
        $consulta->bindValue(":clave", $clave);
        $consulta->bindValue(":nombre", $nombre);
        $consulta->bindValue(":apellido", $apellido);
        $consulta->bindValue(":perfil", $perfil);
        $consulta->bindValue(":foto", $nombreFoto);

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

    public static function MostrarUsuarios($request, $response)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT correo,clave,nombre,apellido,perfil,foto from usuarios");
        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_OBJ);
        
        $nuevaRespuesta = $response->withJson($datos, 200);

        return $nuevaRespuesta;
    }

    public static function GenerarJWT($request, $response)
    {
        $datos = $request->getParsedBody();
        
        $token = AutentificadorJWT::CrearToken($datos);

        $nuevaRespuesta = $response->withJson($token, 200);

        return $nuevaRespuesta;
    }

    public static function VerificarToken($request, $response)
    {
        $datos = $request->getHeader('token');
        $json = new stdClass();

        try
        {
            AutentificadorJWT::VerificarToken($datos[0]);
            $json->mensaje = "Token valido";
            $nuevaRespuesta = $response->withJson($json, 200);
        }
        catch(Exception $e)
        {
            $json->mensaje = $e->getMessage();
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }

    public static function TraerTodosUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT correo,clave,nombre,apellido,perfil,foto from usuarios");        
        
        $consulta->execute();
        
        $retorno = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $retorno; 
    }

    public function ListadoUsuarios($request, $response)
    {
        $datos = Usuario::TraerTodosUsuarios();
        $tabla = "";
        $tabla.= "<table border=1>";
                $tabla.= "<tr>";
                $tabla.= "<td>CORREO</td>";
                $tabla.= "<td>CLAVE</td>";
                $tabla.= "<td>NOMBRE</td>";
                $tabla.= "<td>APELLIDO</td>";
                $tabla.= "<td>PERFIL</td>";
                $tabla.= "<td>FOTO</td>";
                $tabla.= "</tr>";
    
                foreach($datos as $elemento)
                {
                    $tabla.= "<tr>";
                    $tabla.= "<td>" . $elemento->correo . "</td>";
                    $tabla.= "<td>" . $elemento->clave . "</td>";
                    $tabla.= "<td>" . $elemento->nombre . "</td>";
                    $tabla.= "<td>" . $elemento->apellido . "</td>";
                    $tabla.= "<td>" . $elemento->perfil . "</td>";
                    $tabla.= "<td><img src=./fotos/" . $elemento->foto . " width='50px'></td>";
                }

        echo $tabla;
                
    }

}