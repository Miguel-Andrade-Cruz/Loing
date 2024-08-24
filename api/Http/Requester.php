<?php

namespace Minuz\Api\Http;

class Requester
{
    public static function auth(): array|false
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $email = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

            return ['email' => $email, 'password' => $password];
        }

        return ['email' => '', 'password' => ''];
    }



    public static function path(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    
    
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }



    public static function body(): array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}