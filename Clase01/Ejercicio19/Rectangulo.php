<?php

include "FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica
{
    private $ladoUno;
    private $ladoDos;

    public function __construct(float $l1, float $l2)
    {
        $this->ladoUno = $l1;
        $this->ladoDos = $l2;
        //$this->CalcularDatos();
    }

    public function Dibujar()
    {
        $retorno = "<font color=\"pink\">";
        
        for($i = 0; $i < $this->ladoDos;  $i++)
        {
            for($x = 0; $x < $this->ladoUno ; $x++)
            {
                $retorno = $retorno . "*";
            }
            
            $retorno = $retorno . "<br/>";
        }

        $retorno = $retorno . "</font>";

        return $retorno;
        
    }

    protected function CalcularDatos()
    {
        parent::$_superficie = $this->ladoUno * $this->ladoDos;
        parent::$_perimetro = $this->ladoUno * 2 + $this->ladoDos * 2;
    }
}

$rectangulo = new Rectangulo(10, 4);

echo $rectangulo->Dibujar();