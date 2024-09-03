<?php

namespace Minuz\Api\Http;

class Router
{
    public static array $routes = [];


    public static function get(string $path, string $action)
    {
        self::$routes[$path] = [
            'method' => 'GET',
            'action' => $action,
        ];
    }
    
    
    
    public static function post(string $path, string $action)
    {
        self::$routes[$path] = [
            'method' => 'POST',
            'action' => $action,
        ];
    }



    public static function put(string $path, string $action)
    {
        self::$routes[$path] = [
            'method' => 'PUT',
            'action' => $action,
        ];
    }



    public static function delete(string $path, string $action)
    {
        self::$routes[$path] = [
            'method' => 'DELETE',
            'action' => $action
        ];
    }
}