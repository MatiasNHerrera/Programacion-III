<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './vendor/autoload.php';
require_once './clases/Empleado.php';
require_once './clases/AccesoDatos.php';
require_once './clases/Producto.php';
require_once './clases/Mw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

$app->post("[/]", \Empleado::class . ":AgregarEmpleado")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->post("/email/clave", \Empleado::class . ":VerificarEmpleado")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->get("/", \Empleado::class . ":TraerTodosEmpleados")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->post("/productos", \Producto::class . ":AgregarProductos")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->get("/productos", \Producto::class . ":TraerTodosProductos")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->put("/productos", \Producto::class . ":ModificarProducto")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->delete("/productos", \Producto::class. ":BorrarProducto")->add(\MW::class . ":esLogin")->add(\MW::class . ":VerificarToken");

$app->post("/LOGIN", \Empleado::class . ":VerificarJWT");

$app->run();