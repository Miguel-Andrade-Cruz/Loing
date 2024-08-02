<?php

namespace Minuz\Api\core\message;

class Request
{
    public static function request(): array
    {
        $request = file_get_contents('php://input');

        $request_decoded = json_decode($request, true);

        return $request_decoded;
    }



    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}