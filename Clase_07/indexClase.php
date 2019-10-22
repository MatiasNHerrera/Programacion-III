<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './abm_usuario/vendor/autoload.php';

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


/*$app->get('/parametros/{nombre}/[{apellido}]', function (Request $request, Response $response, $args) { 
    $nombre = $args['nombre'];  
    $apellido = isset($args['apellido']) ? $args['apellido'] : null;

    if($apellido != null){
        $response->getBody()->write("Bienvenido: " . $nombre ." - ". $apellido);
    }
    else
    {
        $response->getBody()->write("Bienvenido: " . $nombre);
    }
    return $response;

});
*/
/*
COMPLETAR POST, PUT Y DELETE
*/

/*La barra indica opcionalidad*/  


$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});




$app->group('/json/', function(){

    $this->post('', function (Request $request, Response $response) {

    $datos = $request->getParsedBody();
    $archivos = $request->getUploadedFiles();
    var_dump($datos);
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $destino="./fotos/";
    $nombreAnterior=$archivos['foto']->getClientFilename();    $extension= explode(".", $nombreAnterior);
    $destino .= $nombreAnterior. ".".date("d-m-y") . "." . $extension[1];
    $archivos['foto']->moveTo($destino);
    
    return $datos;
    }); 
    
    $this->get('{nombre}/{apellido}', function (Request $request, Response $response, $args) { 

        $json = new stdClass();

        $json->nombre = $args['nombre'];
        $json->apellido = $args['apellido'];

        $nuevaRespuesta = $response->withJson($json, 200);

        return $nuevaRespuesta;
    
    });

    $this->put('', function (Request $request, Response $response) { 
        
        $datos = $request->getParsedBody();
        
        $json = new stdClass();

        $json = json_decode($datos['json']);

        $nuevaRespuesta = $response->withJson($json, 200);

        return $nuevaRespuesta;
    
    });


});

$app->run(); //SI ESTA NO SE EJECUTA NO FUNCIONA NADA, SE BORRA A VECES