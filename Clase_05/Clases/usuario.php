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
    public $foto;

    public function __construct($json)
    {
        $this->nombre = $json->nombre;
        $this->apellido = $json->apellido;
        $this->clave = $json->clave;
        $this->perfil = $json->perfil;
        $this->correo = $json->correo;
        $this->estado = 1;
        $this->foto = $_FILES["foto"]["name"];
    }

    public function MostrarDatos()
    {
        return $this->id. " - ". $this->nombre. " - ". $this->apellido. " - ". $this->clave. " - ". $this->perfil . " - ". $this->estado. " - ". $this->correo;
    }

    public static function TraerTodosUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT nombre,apellido,clave,perfil,estado,correo,foto FROM usuarios");        
        
        $consulta->execute();
        
        $retorno = $consulta->fetchAll(PDO::FETCH_OBJ); 

        return $retorno; 
    }

    public function InsertarUsuario()
    {
        $validacion = false;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        //$datos = json_decode($_POST["usuario"]);
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,apellido,clave,perfil,estado,correo,foto)"
                                                    . "VALUES(:nombre, :apellido, :clave, :perfil, :estado, :correo, :foto)");

        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':estado', 1);
        $consulta->bindValue(':correo', $this->correo);    
        $consulta->bindValue(':foto', Usuario::SubirFoto());

        if(!Usuario::validarBD($this->correo, $this->clave))
        {
            $validacion = $consulta->execute(); 
        }
        
        return $validacion;

    }
    
    public static function ModificarUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET nombre=:nombre, apellido=:apellido,clave=:clave,perfil=:perfil, estado=:estado, correo=:correo 
        WHERE id=:id");
        
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':correo', $this->correo);
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

    public static function validarBD($correo, $clave)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $datos = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo ='". $correo ."' AND clave = '". $clave . "'");
        $datos->execute();
        $json = json_decode('{"existe" : false, "user" : null }');

        if($datos->rowCount() > 0)
        {
            $json->existe = true;
            $json->user = $datos->fetchAll(PDO::FETCH_OBJ);
        }

        return $json;
    }

    public static function SubirFoto()
    {
        $info = json_decode($_POST["usuario"]);
        $retorno = false;
        $destino = "/fotos/ ". $_FILES["foto"]["name"]; //sigo parado en verificacion.

        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
        {
            $retorno = $destino;
        }

        return $destino;
    }
}