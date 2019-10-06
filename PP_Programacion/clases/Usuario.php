<?php

class Usuario
{
    private $email;
    private $clave;

    public function __construct($email, $clave)
    {   
        $modificado = str_replace(".", "_", $email);
        $this->email = $modificado;
        $this->clave = $clave;
    }

    public function toJSON()
    {
        return '{"email": "' . $this->email . '", "clave": "' . $this->clave . '"}';
    }

    public function GuardarEnArchivo()
    {
        try
        {
            $json = new stdClass();
            $archivo = fopen("./archivos/usuarios.json", "a");
            $cant = fwrite($archivo, $this->toJSON() . "\r\n");

            if($cant > 0)
            {
                $json->exito = true;
                $json->mensaje = "se ha guardado con exito";
            }
            else
            {
                $json->exito = false;
                $json->mensaje = "no se ha podido guardar";
            }

            fclose($archivo);
        }
        catch(Exception $e)
        {
            echo $e.getMessage();
        }

        return json_encode($json);
    }

    public static function TraerTodos()
    {
        $array = array();

        $archivo = fopen("./archivos/usuarios.json", "r");
    
        while(!feof($archivo))
        {
            $datos = trim(fgets($archivo));

            if($datos != null)
            {
                $decodeado = json_decode($datos);
                array_push($array, new Usuario($decodeado->email, $decodeado->clave));
            }
        }

        return $array;
    }

    public static function VerificarExistencia($usuario)
    {
        $datos = Usuario::TraerTodos();
        $retorno = false;

        foreach($datos as $datitos)
        {
            if($datitos->clave == $usuario->clave && $datitos->email == $usuario->email)
            {
                $retorno = true;
            }
        }

        return $retorno;
    }

}