<?php
require_once "./clases/usuario.php";

class Verificadora
{
    public function VerificarVerbo($request, $response, $next)
    {   

        if($request->isGet())
        {
            $response->getBody()->write("Vengo por get: ");
            $next($request, $response);
        }
        else
        {
            $datos = $request->getParsedBody();
            $usuario = new stdClass();
            $usuario->nombre = $datos["nombreUsuario"];
            $usuario->clave = $datos["clave"];
            
            if($datos["tipo"] == "administrador")
            {
                if(Verificadora::ExisteUsuario($usuario))
                {
                    $next($request, $response);
                }
                else
                {
                    echo "el usuario no existe";
                }
            }
            else if($datos["tipo"] == "super_admin")
            {
                $next($request, $response);
            }
            else 
            {
                $response->getBody()->write("no tiene permisos");
            }
        }

        return $response;
    }

    public static function ExisteUsuario($obj)
    {
        $listado = Verificadora::Leer();
        $retorno = false;

        foreach($listado as $usuarios)
        {
            if($obj->nombre == $usuarios[0] && $obj->clave == $usuarios[1])
            {
                $retorno = true;
                break;
            }
        }

        return $retorno;
    }

    public static function Leer()
    {
        $archivo = fopen("./Usuarios.txt", "r");
        $usuarios = array();

        while(!feof($archivo))
        {
            $separacion = explode(",", fgets($archivo));
            array_push($usuarios, $separacion);
        }

        return $usuarios;
    }

}