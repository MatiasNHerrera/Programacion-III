<?php

require_once "Auto.php";

class MW
{
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
            $json->mensaje = "El token no es valido";
            $nuevaRespuesta = $response->withJson($json, 409);
        }

        return $nuevaRespuesta;
    }

    public static function VerificarPerfilPropietario($request, $response, $next)
    {
        $token = $request->getHeader('token');
        $tokenReal = $token[0];
        $datos = AutentificadorJWT::ObtenerData($tokenReal);
        $nuevaRespuesta = "";
        $json = new stdClass();

        if($datos->perfil == "propietario")
        {   
            echo "hola";
            $nuevaRespuesta = $next($request, $response);
        }
        else
        {
            $json->mensaje = "No es propietario, no posee acceso";
            $nuevaRespuesta = $response->withJson($json, 409);
           // $nuevaRespuesta = $next($request, $response);
        }

        return $nuevaRespuesta;
    }   

    public function VerificarPerfilEncargado($request, $response, $next)
    {
        $token = $request->getHeader('token');
        $tokenReal = $token[0];
        $datos = AutentificadorJWT::ObtenerData($tokenReal);
        $nuevaRespuesta = "";
        $json = new stdClass();

        if(strtolower($datos->perfil) == "propietario" || strtolower($datos->perfil == "encargado"))
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
    
}