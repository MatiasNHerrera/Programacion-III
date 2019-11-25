<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './vendor/autoload.php';
require_once './clases/Usuario.php';
require_once './clases/Auto.php';
require_once './clases/AccesoDatos.php';
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

$app->post("/usuarios", \Usuario::class . ":AgregarUsuario");

$app->get("/", \Usuario::class . ":ListadoUsuarios");

$app->post("/", \Auto::class . ":AgregarAuto");

$app->get("/autos", \Auto::class . ":ListadoAutos");

$app->post("/login", \Usuario::class . ":GenerarJWT");

$app->get("/login", \Usuario::class . ":VerificarToken");

$app->delete("/", \Auto::class. ":BorrarAuto")->add(\MW::class . ":VerificarPerfilEncargado")->add(\MW::class . "::VerificarPerfilPropietario")->add(\MW::class . "::VerificarToken");

$app->put("/", \Auto::class. ":ModificarAuto")->add(\MW::class . ":VerificarPerfilEncargado")->add(\MW::class . "::VerificarPerfilPropietario")->add(\MW::class . "::VerificarToken");

$app->run();