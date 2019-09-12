<?php 

class Producto
{
    private $nombre;
    public $cod_barra;
    public $path;

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
        return $this->nombre . " - " . $this->cod_barra;   
    }

    public static function Guardar($obj)
    {
        $retorno = false;

        $archivo = fopen("./Archivos/escritura.txt", "a");

        $cad = fwrite($archivo, $obj->toString() . " - " . $obj->path . "\r\n");

        if($cad > 0)
        {
            $retorno = true;
        }
        
        fclose($archivo);

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
            $auxiliar = explode(" - ", $lectura);
            if(isset($auxiliar[0]) && isset($auxiliar[1]) && isset($auxiliar[2]))
            {
                array_push($array, new Producto($auxiliar[0], $auxiliar[1], $auxiliar[2]));
            }
        }

        fclose($archivo);

        return $array;

     }
}

