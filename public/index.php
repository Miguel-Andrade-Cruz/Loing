<?php

use Minuz\Api\Requester\Requester;
use Minuz\Api\Responser\Responser;
use Minuz\Api\router\Router;

require_once '../vendor/autoload.php';


$request = new Requester();

$controllerClass = Router::Redirect($request::Route());


if ( $controllerClass == false ) {
    Responser::Response([
        'message' => 'Error'
    ]);
}



$controller = new $controllerClass($request::Request());

$response = $controller->Processor();

Responser::Response($response);