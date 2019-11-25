<?php
class Producto
{
    public $nombre;
    public $precio;

    public function AgregarProductos($request, $response)
    {
        $datos = $request->getParsedBody();
        $nombre = $datos["nombre"];
        $precio = $datos["precio"];

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (nombre, precio) values (:nombre, :precio)");
        $consulta->bindValue(":nombre", $nombre);
        $consulta->bindValue(":precio", $precio);

        $consulta->execute();
        
        if($consulta->rowCount() > 0)
        {
            echo "se ha agregado exitosamente";
        }
        else
        {
            echo "no se ha podido agregar";
        }
		
    }

    public static function MostrarProductos($consulta = "SELECT * FROM productos")
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta($consulta);
        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $datos;
    }

    public static function TraerTodosProductos($request, $response)
    {
        $datos = Producto::MostrarProductos();

        return $response->withJson($datos, 200);
    }

    public function ModificarProducto($request, $response)
    {
        $datos = $request->getParsedBody();
        $id = isset($datos["id"]);
        $nombre = isset($datos["nombre"]);
        $precio = isset($datos["precio"]);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre=:nombre, precio=:precio WHERE id=:id");
        $consulta->bindValue(':precio', $precio);
        $consulta->bindValue(':nombre', $nombre);
        $consulta->bindValue(':id', $id);

        $consulta->execute();

        if($consulta->rowCount() > 0)
        {
            echo "Se ha podido modificar";
        }
        else
        {
            echo "No se ha podido de modificar";
        }
    }

    public function BorrarProducto($request, $response)
    {
        $datos = $request->getParsedBody();
        $id = isset($datos["id"]);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id);

        $consulta->execute();

        if($consulta->rowCount() > 0)
        {
            echo "Se ha eliminado";
        }
        else
        {
            echo "No se ha podido eliminar, cheque";
        }
    }
}