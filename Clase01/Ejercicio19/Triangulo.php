<?php

include "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica
{
    private $ladoUno;
    private $ladoDos;

    public function __construct(double $l1, double $l2)
    {
        $this->ladoUno = $l1;
        $this->ladoDos = $l2;
    }

    public function Dibujar()
    {
        $retorno = "El color es: ". parent::GetColor();

        
    }

    protected function CalcularDatos()
    {
        parent::$_superficie = ($this->ladoUno * $this->ladoDos) / 2;
        parent::$_perimetro = $this->ladoUno + $this->ladoDos;
    }
}