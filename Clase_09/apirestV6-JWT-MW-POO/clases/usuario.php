<?php
class usuario
{
	public $nombre;
 	public $clave;
    public $perfil;
      
    public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, clave, perfil from usuarios where nombre = '$id'");
			$consulta->execute();
			$UsuarioBuscado= $consulta->fetchObject('usuario');
			return $UsuarioBuscado;					
    }
    
}
