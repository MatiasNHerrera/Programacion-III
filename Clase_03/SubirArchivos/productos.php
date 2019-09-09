<?php 

class Producto
{
    private $nombre;
    private $cod_barra;
    private $path;

    public function __construct($n = null , $c = null, $p = null)
    {   
        if($n != null && $c != null && $p != null)
        {
            $this->nombre = $n;
            $this->cod_barra = $c;
            $this->path = $p;
        }
    }

    public function toString()
    {
        return $this->cod_barra . "-" . $this->nombre . "-" . $this->path ."\n\r";   
    }

    public static function Guardar($obj)
    {
        $retorno = false;

        $archivo = fopen("./Archivos/escritura.txt", "a");

        $cad = fwrite($archivo, $obj->toString());

        if($cad > 0)
        {
            $retorno = true;
        }

        return $retorno;
    }

    public static function TraerTodosLosProductos()
    {
        $array = array();
        $auxiliar = array();
        $archivo = fopen("./Archivos/escritura.txt", "r");
        
        while(!feof($archivo))
        {
            $lectura = fgets($archivo);
            $auxiliar = explode("-", $lectura);
            if(isset($auxiliar[1]) && isset($auxiliar[2]) && isset($auxiliar[0]))
            {
                array_push($array, new Producto($auxiliar[1], $auxiliar[0]), $auxiliar[2]);
            }
        }

        fclose($archivo);

        return $array;

     }
}

