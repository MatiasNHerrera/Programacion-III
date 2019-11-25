<?php

require_once "AutentificadorJWT.php";

class MW
{
    public function esLogin($request, $response, $next)
    {
        $token = $request->getHeader('token');
        $tokenReal = $token[0];
        $datos = AutentificadorJWT::ObtenerData($tokenReal);
        $nuevaRespuesta = "";

        if($request->isGet())
        {
            if(strtolower($datos->perfil) == "user" || strtolower($datos->perfil) == "admin")
            {
                $nuevaRespuesta = $next($request, $response);
            }
            else
            {
                $nuevaRespuesta = $response->withJson("No tiene permisos", 200);
            }
        }
        else
        {
            if(strtolower($datos->perfil) == "admin")
            {
                $nuevaRespuesta = $next($request, $response);
            }
            else
            {
                $nuevaRespuesta = $response->withJson("No tiene permisos", 200);
            }
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

}