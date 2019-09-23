<?php
require "AccesoDatos.php";

class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $perfil;
    public $estado;
    public $correo;

    public function MostrarDatos()
    {
        return $this->id. " - ". $this->nombre. " - ". $this->apellido. " - ". $this->clave. " - ". $this->perfil . " - ". $this->estado. " - ". $this->correo;
    }

    public static function TraerTodosUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT nombre,apellido,clave,perfil,estado,Correo FROM usuarios");        
        
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);                                                

        return $consulta; 
    }

    public function InsertarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,apellido,clave,perfil,estado,Correo)"
                                                    . "VALUES(:nombre, :apellido, :clave, :perfil, :estado, :Correo)");
        
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':Correo', $this->correo);

        $validacion = $consulta->execute(); 
        
        return $validacion;

    }
    
    public static function ModificarUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET nombre=:nombre, apellido=:apellido,clave=:clave,perfil=:perfil, estado=:estado, Correo=:correo 
        WHERE id=:id");
        
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':Correo', $this->correo);
        $consulta->bindValue(':id', $this->id);


        $validacion = $consulta->execute(); 

        return $validacion;
    }
    
    public static function EliminarCD($usuario)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
        
        $consulta->bindValue(':id', $usuario->id);

        $validacion = $consulta->execute();

        return $validacion;
    }
}