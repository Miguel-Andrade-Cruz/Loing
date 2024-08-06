<?php

namespace Minuz\Api\core\message;

class Response
{
    public static function json(array $data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }


    public static function unsafe_operation_response()
    {
        return self::json(
            [
                'message' => 'Warning: Unsafety method to do this operation.'
            ]
        );
    }
}