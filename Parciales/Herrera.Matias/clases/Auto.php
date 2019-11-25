<?php
class Auto
{
    public $color;
    public $marca;
    public $precio;
    public $modelo;

    public static function AgregarAuto($request, $response)
    {
        $datos = $request->getParsedBody();
        $autoDatos = json_decode($datos["json"]);
        $json = new stdClass();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO autos (color,marca,precio,modelo) values (:color,:marca,:precio,:modelo)");
        $consulta->bindValue(":color", $autoDatos->color);
        $consulta->bindValue(":marca", $autoDatos->marca);
        $consulta->bindValue(":precio", $autoDatos->precio);
        $consulta->bindValue(":modelo", $autoDatos->modelo);

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

    public static function TraerTodosAutos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT color,marca,precio,modelo from autos");        
        
        $consulta->execute();
        
        $retorno = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $retorno; 
    }

    public function ListadoAutos($request, $response)
    {
        $json = new stdClass();
        $datos = Auto::TraerTodosAutos();
        $tabla = "";
        $tabla.= "<table border=1>";
                $tabla.= "<tr>";
                $tabla.= "<td>COLOR</td>";
                $tabla.= "<td>MARCA</td>";
                $tabla.= "<td>PRECIO</td>";
                $tabla.= "<td>MODELO</td>";
                $tabla.= "</tr>";
    
                foreach($datos as $elemento)
                {
                    $tabla.= "<tr>";
                    $tabla.= "<td>" . $elemento->color . "</td>";
                    $tabla.= "<td>" . $elemento->marca . "</td>";
                    $tabla.= "<td>" . $elemento->precio . "</td>";
                    $tabla.= "<td>" . $elemento->modelo . "</td>";
                }

        $json->exito = true;
        $json->mensaje = "Tabla";
        echo $tabla;
        return $response->withJson($json, 200);
    }

    public function BorrarAuto($request, $response)
    {
        $json = new stdClass();
        $token = $request->getHeader('token');
        $datos = $request->getParsedBody();
        $tokenReal = $token[0];
        $autoDatos = AutentificadorJWT::ObtenerData($tokenReal);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM autos WHERE id = :id");
        $consulta->bindValue(':id', $datos["id"]);

        if($autoDatos->perfil == "propietario")
        {   
            $consulta->execute();
        }

        if($consulta->rowCount() > 0)
        {
            $json->exito = true;
            $json->mensaje = "Se ha podido borrar";
            $nuevaRespuesta = $response->withJson($json, 200);  
        }
        else
        {
            $json->exito = false;
            $json->mensaje = "No se ha podido borrar, el usuario fue " . $autoDatos->nombre;
            $nuevaRespuesta = $response->withJson($json, 418); 
        }

        return $nuevaRespuesta;
    }


     public function ModificarAuto($request, $response)
    {
        $json = new stdClass();
        $token = $request->getHeader('token');
        $datos = $request->getParsedBody();
        $autoJson = json_decode($datos["json"]);
        $tokenReal = $token[0];
        $auto = AutentificadorJWT::ObtenerData($tokenReal);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE autos SET color=:color, marca=:marca,precio=:precio,modelo=:modelo WHERE id=:id");
        $consulta->bindValue(':color', $autoJson->color);
        $consulta->bindValue(':marca', $autoJson->marca);
        $consulta->bindValue(':precio', $autoJson->precio);
        $consulta->bindValue(':modelo', $autoJson->modelo);
        $consulta->bindValue(':id', $datos["id"]);

        if(strtolower($auto->perfil) == "propietario" || strtolower($auto->perfil) == "encargado")
        {
            $consulta->execute(); 
        }

        if($consulta->rowCount() > 0)
        {
            $json->exito = true;
            $json->mensaje = "Se ha podido modificar";
            $nuevaRespuesta = $response->withJson($json, 200);
        }
        else
        {
            $json->exito = false;
            $json->mensaje = "No se ha podido modificar, el usuario fue " . $auto->nombre;
            $nuevaRespuesta = $response->withJson($json, 418); 
        }

        return $nuevaRespuesta;
    }


}