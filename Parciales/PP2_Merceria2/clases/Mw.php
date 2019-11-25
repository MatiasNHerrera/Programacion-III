<?php

require_once "Media.php";

class MW
{
    public function VerificarCorreoClave($request, $response,$next)
    {
        $datos = $request->getParsedBody(); 
        $correo = $datos["correo"];
        $clave = $datos["clave"];
        $retorno = new stdClass();

        if(isset($correo) && isset($clave))
        {
            $retorno->mensaje = "Se encuentran seteados";
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $retorno->mensaje = "No se en encuentran seteados";
            $nuevaRespuesta = $response->withJson($retorno, 409);
        }

        return $nuevaRespuesta;
    }

    public function VerificarCorreoClaveEmpty($request, $response, $next)
    {
        $datos = $request->getParsedBody(); 
        $correo = isset($datos["correo"]);
        $clave = isset($datos["clave"]);
        $retorno = new stdClass();

        if(!empty($correo) && !empty($clave))
        {
            $retorno->mensaje = "No se encuentran vacio";
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $retorno->mensaje = "Se encuentran vacios";
            $nuevaRespuesta = $response->withJson($retorno, 409);
        }

        return $nuevaRespuesta;
    }

    public function VerificarBD($request, $response, $next)
    {
        $Usuarios = Usuario::TraerTodosUsuarios();
        $datos = $request->getParsedBody();
        $correo = $datos["correo"];
        $clave = $datos["clave"];
        $flag = false;
        $json = new stdClass();
        $nuevaRespuesta = "";

        foreach($Usuarios as $datitos)
        {
            if($datitos->correo == $correo && $datitos->clave == $clave)
            {
                $flag = true;
                break;
            }
        }

        if($flag)
        {
            $json->mensaje = "No se encuentra";
            $nuevaRespuesta = $response->withJson($json, 409);
        }
        else
        {
            $nuevaRespuesta = $next($request, $response);
        }

        return $nuevaRespuesta;

    }

    public function VerificarToken($request, $response, $next)
    {
        $datos = $request->getHeader('token');
        $json = new stdClass();

        try
        {
            AutentificadorJWT::VerificarToken($datos[0]);
            $nuevaRespuesta = $next($request, $response);
        }
        catch(Exception $e)
        {
            $json->mensaje = $e->getMessage();
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }

    public static function VerificarPerfilPropietario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = json_decode($datos["json"]);
        $nuevaRespuesta = "";
        $json = new stdClass();

        if($usuario->perfil == "propietario")
        {   
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $json->mensaje = "No es propietario, no posee acceso";
            $nuevaRespuesta = $response->withJson($json, 409);
            $nuevaRespuesta = $next($request, $response);
        }

        return $nuevaRespuesta;
    }   

    public function VerificarPerfilEncargado($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = json_decode($datos["json"]);
        $nuevaRespuesta = "";
        $json = new stdClass();

        if(strtolower($usuario->perfil) == "propietario" || strtolower($usuario->perfil == "encargado"))
        {   
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $json->mensaje = "No es encargado ni propietario, no posee acceso";
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }

    public function VerificarPerfilEmpleado($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $perfil = $datos["perfil"];
        $nuevaRespuesta = "";
        $json = new stdClass();

        if(strtolower($perfil) == "empleado")
        {   
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $json->mensaje = "No es empleado, no posee acceso";
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }    
    
}