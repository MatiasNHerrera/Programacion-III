<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/Verificadora.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
�La primera l�nea es la m�s importante! A su vez en el modo de 
desarrollo para obtener informaci�n sobre los errores
 (sin �l, Slim por lo menos registrar los errores por lo que si est� utilizando
  el construido en PHP webserver, entonces usted ver� en la salida de la consola 
  que es �til).

  La segunda l�nea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera m�s predecible.
*/

$app = new \Slim\App(["settings" => $config]);


$app->put("/", function(Request $request, Response $response){

  
});

$app->delete("/", function(Request $request, Response $response){

  
});

$app->group("/credenciales", function(){


  $this->get("/", function(Request $request, Response $response){

      $response->getBody()->write("hola get");

      return $response;

  });

  $this->post("/", function(Request $request, Response $response){

      $datos = $request->getParsedBody();
      $response->getBody()->write("el nombre del administrador es: " . $datos["nombre"]);
      return $response;
    
  });

})->add(function(Request $request, Response $response, $next){

    if($request->isGet())
    {
      $response->getBody()->write("Vengo por get: ");
      $next($request, $response);
    }
    else
    {
      $datos = $request->getParsedBody();

      if($datos["tipo"] == "administrador")
      {
          $next($request, $response);
      }
      else 
      {
          $response->getBody()->write("no tiene permisos");
      }
    }

    return $response;

});

$app->group("/credenciales/POO", function(){

  $this->get("/", function(Request $request, Response $response){

    $response->getBody()->write("hola get");
    return $response;

  });

  $this->post("/", function(Request $request, Response $response){

      $datos = $request->getParsedBody();
      $response->getBody()->write("el nombre del administrador es: " . $datos["nombre"]);
      return $response;

  });

})->add(\Verificadora::class . ":VerificarVerbo");

$app->group("/credenciales/post", function(){

    $this->post("/Insertar", \Usuario::class . ":AgregarUsu");

})->add(\Verificadora::class . ":VerificarVerbo");

$app->group("/credenciales/delete", function(){

    $this->delete("/", \Usuario::class . ":DeleteUsuario");

})->add(\Verificadora::class . ":VerificarVerbo");

$app->run();