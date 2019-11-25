<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './vendor/autoload.php';
require_once './clases/Media.php';
require_once './clases/Usuario.php';
require_once './clases/Mw.php';
require_once './clases/AccesoDatos.php';

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

$app->post("[/]", \Media::class . ":AgregarMedia");

$app->get("/medias", \Media::class . ":MostrarMedias");

$app->post("/usuarios", \Usuario::class . ":AgregarUsuario");

$app->get("/", \Usuario::class . ":MostrarUsuarios");

$app->post("/login", \Usuario::class. ":GenerarJWT")->add(\MW::class . ":VerificarCorreoClave")->add(\MW::class . "::VerificarCorreoClaveEmpty")->add(\MW::class . ":VerificarBD");

$app->get("/login", \Usuario::class. ":VerificarToken");

$app->delete("[/]", \Media::class. ":BorrarMedia")->add(\MW::class . ":VerificarToken")->add(\MW::class . "::VerificarPerfilPropietario")->add(\MW::class . "::VerificarPerfilEncargado");

$app->put("[/]", \Media::class. ":ModificarMedia")->add(\MW::class . ":VerificarToken")->add(\MW::class . "::VerificarPerfilPropietario")->add(\MW::class . "::VerificarPerfilEncargado");

$app->group("/listados", function(){

    $this->get("/sinId", function(Request $request, Response $response){

      $datos = Media::MostrarMedias("SELECT color,marca,precio,talle FROM medias");
        
      $nuevaRespuesta = $response->withJson($datos, 200);

      return $nuevaRespuesta;

    })->add(\MW::class . ":VerificarPerfilEncargado");

    $this->get("/colores", function(Request $request, Response $response){

      $datos = Media::MostrarMedias("SELECT color FROM medias");
      $array = array();

      foreach($datos as $datitos)
      {
        array_push($array, $datitos->color);
      }

      $colores = array_unique($array);
      $cantidadColores = count($colores);
      
      $nuevaRespuesta = $response->withJson("la cantidad de colores es: " . $cantidadColores, 200);

      return $nuevaRespuesta;

    })->add(\MW::class . ":VerificarPerfilEncargado");

    $this->get("/propietario/[{propietario}]", function(Request $request, Response $response, $EsProp){

      $id = isset($EsProp["propietario"]);

      if(isset($EsProp["propietario"]))
      {
          $datos = Media::MostrarMedias("SELECT * FROM medias WHERE id = $id");
      }
      else
      {
          $datos = Media::MostrarMedias();
      }

      return $response->withJson($datos, 200);

    })->add(\MW::class . ":VerificarPerfilPropietario");

});

$app->run();