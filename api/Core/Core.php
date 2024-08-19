<?php

namespace Minuz\Api\Core;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;
use Minuz\Api\Tools\Parser;

class Core
{
    public static function dispatch(array $routes)
    {
        $prefixController = 'Minuz\\Api\\Controllers\\';

        $uri = Requester::path();

        $uriData = Parser::treatURI($uri);
        
        $route = $uriData['route path']; 

        if ( ! array_key_exists($route, $routes) ) {
            $controllerClass = $prefixController . 'NotFoundController';
            $controller = new $controllerClass();
            
            $controller->index(new Requester, new Responser);
            return;
        }
        $route = $routes[$route];


        if( Requester::method() != $route['method'] ) {
            $responseData = [
                'Status Message' => 'Error',
                'Warning' => 'Method not allowed.'
            ];
            
            Responser::Response($responseData, 405);
            return;
        }


        [$controllerClass, $action] = explode('||', $route['action']);

        $controllerClass = $prefixController . $controllerClass;
        $controller = new $controllerClass();

        $controller->$action(new Requester, new Responser, $uriData['id'], $uriData['queries']);

        return;
    }
}