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
        $usuarioDatos = json_decode($datos["json"]);
        $destino = "./fotos/" . $nombreFoto;
        $foto['foto']->moveTo($destino);
        $json = new stdClass();
        $nuevaRespuesta = "";
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,apellido,perfil,foto) values (:correo,:clave,:nombre,:apellido,:perfil,:foto)");
        $consulta->bindValue(":correo", $usuarioDatos->correo);
        $consulta->bindValue(":clave", $usuarioDatos->clave);
        $consulta->bindValue(":nombre", $usuarioDatos->nombre);
        $consulta->bindValue(":apellido", $usuarioDatos->apellido);
        $consulta->bindValue(":perfil", $usuarioDatos->perfil);
        $consulta->bindValue(":foto", $nombreFoto);

        $consulta->execute();
        
        if($consulta->rowCount() > 0)
        {
            $json->exito = true;
            $json->mensaje = "Se ha podido agregar";
            $nuevaRespuesta = $response->withJson($json, 200);            
        }
        else
        {
            $json->exito = true;
            $json->mensaje = "No se ha podido agregar";
            $nuevaRespuesta = $response->withJson($json, 418); 
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
        $json = new stdClass();
        $datos = Usuario::TraerTodosUsuarios();
        $nuevaRespuesta = " ";
        $tabla = "";
        $tabla.= "<table border=1>";
                $tabla.= "<tr>";
                $tabla.= "<td>CORREO";
                $tabla.= "<td>CLAVE";
                $tabla.= "<td>NOMBRE";
                $tabla.= "<td>APELLIDO";
                $tabla.= "<td>PERFIL";
                $tabla.= "<td>FOTO";
                $tabla.= "</tr>";
    
                foreach($datos as $elemento)
                {
                    $tabla.= "<tr>";
                    $tabla.= "<td>" . $elemento->correo ;
                    $tabla.= "<td>" . $elemento->clave;
                    $tabla.= "<td>" . $elemento->nombre; 
                    $tabla.= "<td>" . $elemento->apellido; 
                    $tabla.= "<td>" . $elemento->perfil ;
                    $tabla.= "<td><img src=./fotos/" . $elemento->foto . " width='50px'>";
                }

        $json->exito = true;
        $json->mensaje = "Tabla";
        $json->tabla = $tabla;
        $nuevaRespuesta = $response->withJson($json,200);
        return $nuevaRespuesta;
                
    }

    public function GenerarJWT($request, $response)
    {
        $Usuarios = Usuario::TraerTodosUsuarios();
        $datos = $request->getParsedBody();
        $correo = $datos["correo"];
        $clave = $datos["clave"];
        $flag = false;
        $json = new stdClass();
        $usuarioInfo = "";
        $nuevaRespuesta = "";

        foreach($Usuarios as $datitos)
        {
            if($datitos->correo == $correo && $datitos->clave == $clave)
            {
                $flag = true;
                $usuarioInfo = $datitos;
                break;
            }
        }

        if($flag)
        {
            $json->jwt = AutentificadorJWT::CrearToken($usuarioInfo);
            $json->exito = true;
            $nuevaRespuesta = $response->withJson($json, 200);
        }
        else
        {   
            $json->exito = false;
            $json->jwt = null;
            $nuevaRespuesta = $response->withJson($json, 403);
        }

        return $nuevaRespuesta;
    }

    public function VerificarToken($request, $response)
    {
        $datos = $request->getHeader('token');
        $json = new stdClass();
        $nuevaRespuesta = "";

        try
        {
            AutentificadorJWT::VerificarToken($datos[0]);
            $json->mensaje = "El token es valido";
            $nuevaRespuesta = $response->withJson($json, 200);
        }
        catch(Exception $e)
        {
            $json->mensaje = "El token no valido";
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }
}