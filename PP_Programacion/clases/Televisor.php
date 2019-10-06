<?php
require_once "IParte3.php";
require_once "IParte2.php";
require_once "IParte4.php";
require_once "AccesoDatos.php";

class Televisor implements IParte2, IParte3, IParte4
{
    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;

    public function __construct($tipo = null, $precio = null, $paisOrigen = null, $path = null)
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->path = $path;
    }

    public function toJSON()
    {
        $aux = new stdClass();

        $aux->tipo = $this->tipo;
        $aux->precio = $this->precio;
        $aux->paisOrigen = $this->paisOrigen;
        $aux->path = $this->path;

        return json_encode($aux);
    }


    public function Agregar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO televisores (tipo, precio, pais, foto) VALUES (:tipo, :precio, :pais, :foto)"); 

        $consulta->bindValue(":tipo", $this->tipo);
        $consulta->bindValue(":precio", $this->precio);
        $consulta->bindValue(":pais", $this->paisOrigen);

        if($this->path != null)
        {
            $consulta->bindValue(":foto", $this->path);
        }
        else
        {
            $consulta->bindValue(":foto", " ");
        }
        
        $validacion = $consulta->execute();

        return $validacion;
    }

    public function Traer()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM televisores");
        
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);

        return $consulta;
        
    }

    public function CalcularIVA()
    {
        return $this->precio * 1.21;
    }

    public function Modificar($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE televisores SET tipo=:tipo,precio=:precio,pais=:pais,foto=:foto WHERE id=:id");

        $consulta->bindValue(':id',$id);
        $consulta->bindValue(':tipo', $this->tipo);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':pais', $this->paisOrigen);
        $consulta->bindValue(':foto', $this->path);
    
        $consulta->execute();
        
        $validacion = false;

        if($consulta->rowCount() > 0)
        {
            $validacion = true;
        }
        
        return $validacion;   
    }

    public function Eliminar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM televisores WHERE tipo=:tipo");
        $consulta->bindValue(':tipo', $this->tipo);
        $consulta->execute();
        $validacion = false;

        if($consulta->rowCount() > 0)
        {
            $validacion = true;
        }
        
        return $validacion;
    }

    public function ExisteEnBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais FROM televisores WHERE tipo=:tipo");

        $consulta->bindValue(':tipo', $this->tipo);

        $validacion = $consulta->execute();
        
        return $validacion;
        
    }

    public function Filtrar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        if(isset($this->tipo) && isset($this->paisOrigen) == false)
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais, foto as 'path' FROM televisores WHERE tipo=:tipo");
            $consulta->bindValue(':tipo', $this->tipo);
        }
        else if(isset($this->tipo) == false && isset($this->paisOrigen))
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais, foto as 'path' FROM televisores WHERE pais=:pais");
            $consulta->bindValue(':pais', $this->paisOrigen);
        }
        else if(isset($this->tipo) && isset($this->paisOrigen))
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais, foto as 'path' FROM televisores WHERE (tipo=:tipo AND pais=:pais )");
            $consulta->bindValue(':tipo', $this->tipo);
            $consulta->bindValue(':pais', $this->paisOrigen);
        }
        else
        {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais, foto as 'path' FROM televisores");
        }

        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);


        return $consulta;
    }
    
}