<?php 

class Producto
{
    private $nombre;
    private $cod_barra;

    public function __construct($n = null , $c = null)
    {   
        if($n != null && $c != null)
        {
            $this->nombre = $n;
            $this->cod_barra = $c;
        }
    }

    public function toString()
    {
        return $this->cod_barra . " - " . $this->nombre . "\n\r";   
    }

    public static function Guardar($obj)
    {
        $retorno = false;

        $archivo = fopen("./archivo.txt", "a");

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
        $archivo = fopen("./archivo.txt", "r");
        
        while(!feof($archivo))
        {
            $lectura = fgets($archivo);
            $auxiliar = explode("-", $lectura);
            array_push($array, new Producto($auxiliar[1], $auxiliar[0]));
        }

        for($i = 0; $i < count($array); $i++)
        {
            echo($array[$i]->toString()). "<br/>";
        }

     }
}

