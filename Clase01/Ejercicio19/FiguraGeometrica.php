<?php

class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;

    public function __construct()
    {
       
    }

    public function GetColor()
    {
        return $this->_color;
    }

    public function SetColor(string $color)
    {
        $this->_color = color;
    }

    public function toString()
    {
        return $this->_color. (string)$this->_perimetro. (string)$this->_superficie;
    }

    public abstract function Dibujar();
    protected abstract function CalcularDatos();

}