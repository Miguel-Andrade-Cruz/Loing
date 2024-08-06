<?php

namespace Minuz\Api\router;
use Minuz\Api\controller\LoginController;

class Router
{
    private static array $routes = [
        'POST || /login' => LoginController::class
    ];

    public static function Redirect(string $route): string|false
    {
        if ( ! array_key_exists($route, self::$routes) ) {
            return false;
        }

        return self::$routes[$route];
    }
}