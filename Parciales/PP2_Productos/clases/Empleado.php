<?php

require_once "AutentificadorJWT.php";

class Empleado
{
    public $nombre;
    public $apellido;
    public $email;
    public $foto;
    public $legajo;
    public $perfil;
    public $clave;

    public function AgregarEmpleado($request, $response)
    {
        $datos = $request->getParsedBody();
        $foto = $request->getUploadedFiles();
        $path = $foto['foto']->getClientFilename();
        $extension = explode(".", $path);
        $nombreFoto = date("H-m-s") . ".".$extension[1];
        $email = $datos["email"];
        $clave = $datos["clave"];
        $nombre = $datos["nombre"];
        $apellido = $datos["apellido"];
        $perfil = $datos["perfil"];
        $legajo = $datos["legajo"];
        $destino = "./fotos/" . $nombreFoto;
        $foto['foto']->moveTo($destino);

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,apellido,email,foto,legajo,clave,perfil) values (:nombre,:apellido,:email,:foto,:legajo,:clave,:perfil)");
        $consulta->bindValue(":email", $email);
        $consulta->bindValue(":clave", $clave);
        $consulta->bindValue(":nombre", $nombre);
        $consulta->bindValue(":apellido", $apellido);
        $consulta->bindValue(":perfil", $perfil);
        $consulta->bindValue(":legajo", $legajo);
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

    public static function MostrarEmpleados($consulta = "SELECT * FROM empleados")
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($consulta);
        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $datos;
    }

    public function VerificarEmpleado($request, $response)
    {
        $datos = $request->getParsedBody();
        $email = $datos["email"];
        $clave = $datos["clave"];

        $retorno = new stdClass();

        $empleados = Empleado::MostrarEmpleados("SELECT * FROM empleados WHERE email = '$email' AND clave='$clave'");

        if($empleados != null)
        {
            $retorno->valido = true;
            $retorno->usuario= $empleados;
        }
        else
        {
            $retorno->valido = false;
            $retorno->usuario= "No se ha encontrado usuario";
        }

        $nuevaRespuesta = $response->withJson($retorno, 200);

        return $nuevaRespuesta;

    }

    public static function TraerTodosEmpleados($request, $response)
    {
        $datos = Empleado::MostrarEmpleados();

        return $response->withJson($datos, 200);
    }

    public function VerificarJWT($request, $response)
    {
        $datos = $request->getParsedBody();
        $email = $datos["email"];
        $clave = $datos["clave"];

        $retorno = new stdClass();

        $empleados = Empleado::MostrarEmpleados("SELECT * FROM empleados WHERE email = '$email' AND clave='$clave'");

        if($empleados != null)
        {
            $token = AutentificadorJWT::CrearToken($datos); 
            $nuevaRespuesta = $response->withJson($token, 200);
        }
        else
        {
            $nuevaRespuesta = $response->withJson("No se han encontrado los datos", 200);
        }

        return $nuevaRespuesta;
    }

}