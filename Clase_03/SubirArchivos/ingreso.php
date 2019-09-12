<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="Administracion.php" method="POST" enctype="multipart/form-data"> 
    <table border="1">
    <tr>
        <td>
        Nombre
        <input type="text" value="" name="nombre" id="nombre">
        </td>
        <td rowspan = "10">
        <?php
        include "productos.php";
    
        $array = Producto::TraerTodosLosProductos();

        for($i = 0; $i < count($array); $i++)
        {  

            if($array[$i]->path != null ){
                echo "<img src='" . $array[$i]->path . "' width='10%'";
            }

            if(isset($array[$i])){
            echo "<br/>";
            echo ($array[$i]->toString());

            echo "<br/>";
            }
        }
        ?>
        </td>
    </tr>

    <tr>
        <td>
        Codigo
        <input type="text" value="" name="codigo" id="codigo">
        </td>
    </tr>

    <tr>
        <td colspam>
        <input type="file" name="archivo">
        </td>
    </tr>

    <tr>
        <td>
            <input type="submit" id="btnGuardar" value="Guardar" onclick=>
        </td>
    </tr>
    </td>

    </table>
    
    </form>

</body>
</html>

