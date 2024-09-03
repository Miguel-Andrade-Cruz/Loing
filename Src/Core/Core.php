<?php

namespace Minuz\Api\Core;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;
use Minuz\Api\Tools\Detacher;

class Core
{
    public static function dispatch(array $routes)
    {
        $prefixController = 'Minuz\\Api\\Controllers\\';

        $url = Requester::path();
        Detacher::Detach($url, $urlData);
        
        $route = $urlData['path'];
        
        if ( Requester::method() == 'OPTIONS' ) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            header("Access-Control-Allow-Headers: Authorization, Content-Type");
            return;
        }
        if ( Requester::path() == '/' ) {
            Responser::Response(200, 'Ok', 'Hello from LoingAPI!');
            return;
        }
        if ( ! array_key_exists($route, $routes) ) {
            $controllerClass = $prefixController . 'NotFoundController';
            $controller = new $controllerClass();
            $controller->index(new Requester, new Responser);
        
            return;
        }
        $route = $routes[$route];


        if( Requester::method() != $route['method'] ) {
            Responser::Response(405, 'Error', 'Method not allowed');
            return;
        }

        [$controllerClass, $action] = explode('||', $route['action']);

        $controllerClass = $prefixController . $controllerClass;
        $controller = new $controllerClass();

        $controller->$action(new Requester, new Responser, $urlData['id'], $urlData['query']);

        return;
    }
}