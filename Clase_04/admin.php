<?php
$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

$host = "localhost";
$user = "root";
$pass = "";
$base = "mercado";

$con = @mysqli_connect($host, $user, $pass, $base);

echo "<pre>con = mysqli_connect(host, user, pass)</pre>";
echo $queHago;

if(!$con)
{
    echo "<pre>Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL . "</pre>";
    return;
}

echo "<pre>Éxito: Se realizó una conexión a MySQL!!!." . PHP_EOL;
echo "Información del host: " . mysqli_get_host_info($con) . PHP_EOL . "</pre>";

switch("TraerTodos_Productos")
{
    case "TraerTodos_Usuarios":
    $sql = "SELECT * FROM usuarios";

    $rs = $con->query($sql); //ejecuto la consulta

    while ($row = $rs->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
         $user_arr[] = $row;
    }

    var_dump($user_arr);

    break;

    case "TraerPorId_Usuarios":

    $id_usuario = $_POST["id_usuario"];

    $sql = "SELECT * FROM usuarios where id=". $id_usuario;

    $rs = $con->query($sql); //ejecuto la consulta

    while ($row = $rs->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
        $user_arr[] = $row;
    }

    var_dump($user_arr);

    break;


    case "TraerPorEstado_Usuarios":
    
    $estado = $_POST["estado_usuario"];

    $sql = "SELECT * FROM usuarios where estado=" . $estado;

    $rs = $con->query($sql); //ejecuto la consulta

    while ($row = $rs->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
        $user_arr[] = $row;
    }

    var_dump($user_arr);

    break;

    case "Agregar_Usuarios":

    $nombre = $_POST["nombre_usuario"];
    $apellido = $_POST["apellido_usuario"];
    $clave = $_POST["clave_usuario"];
    $perfil = $_POST["perfil_usuario"];
    $estado = $_POST["estado_usuario"];


    $sql = "INSERT INTO usuarios (nombre,apellido,clave,perfil,estado)
                VALUES('$nombre','$apellido','$clave','$perfil','$estado')";

    $rs = $con->query($sql);
    if(mysqli_affected_rows($con)>0)
    {
        echo "agregado con exito";
    }

    break;

    case "Modificar_usuarios":
        
        $id_usuario = $_POST["id_usuario"];
        $nombre = $_POST["nombre_usuario"];
        $apellido = $_POST["apellido_usuario"];
        $clave = $_POST["clave_usuario"];
        $perfil = $_POST["perfil_usuario"];
        $estado = $_POST["estado_usuario"];

        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido',clave='$clave',perfil='$perfil', estado='$estado' 
        WHERE id=" . $id_usuario;

        $rs = $con->query($sql);

        if(mysqli_affected_rows($con)> 0)
        {
            echo "modificado con exito";
        }

        break;

    case "Borrar_Usuarios":

        $id_usuario = $_POST["id_usuario"];

        $sql = "DELETE FROM usuarios WHERE id=" . $id_usuario;

        $rs = $con->query($sql);

        if(mysqli_affected_rows($con)>0)
        {
            echo "usuario eliminado con exito";
        }

        break;

    case "TraerTodos_Productos":

        $sql = "SELECT * FROM productos";
    
        $rs = $con->query($sql); //ejecuto la consulta
    
        while ($row = $rs->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
             $user_arr[] = $row;
        }

        $table = "<table> 
                        <tr>
                            <td>
                                Nombre
                            </td>
                            <td>
                                Codigo De Barra
                            </td>
                            <td>
                                Path
                            </td>
                            
                        </tr>
                        
                        ";
    
        echo $table;

        break;

    case "TraerPorId_Productos":
    
    $id_producto = $_POST["id_productos"];

    $sql = "SELECT * FROM productos where id=". $id_producto;

    $rs = $con->query($sql); //ejecuto la consulta

    while ($row = $rs->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
        $user_arr[] = $row;
    }

    var_dump($user_arr);

    break;

    case "Agregar_Producto":

    $nombre = $_POST["nombre_producto"];
    $codigo_barra = $_POST["codigo_barra"];
    $path_foto = $_POST["path_producto"];

    $sql = "INSERT INTO productos (codigo_barra,nombre,path_foto)
    VALUES ('$codigo_barra', '$nombre', '$path_foto')";

    $rs = $con->query($sql);
    if(mysqli_affected_rows($con)>0)
    {
        echo "agregado con exito";
    }

    break;

    case "Modificar_Producto":

    $nombre = $_POST["nombre_producto"];
    $codigo_barra = $_POST["codigo_barra"];
    $path_foto = $_POST["path_producto"];
    $id_producto = $_POST["id_producto"];

    $sql = "UPDATE productos SET codigo_barra='$codigo_barra', nombre='$nombre' ,path_foto='$path_foto' WHERE id=" . $id_producto;
    
    $rs = $con->query($sql);

    if(mysqli_affected_rows($con)> 0)
    {
        echo "modificado con exito";
    }
    
    break;
}

echo "<pre>mysqli_close(con);</pre>";
mysqli_close($con); 