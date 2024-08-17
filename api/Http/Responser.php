<?php

namespace Minuz\Api\Http;

class Responser
{
    public static function Response(array $data, $code)
    {
        header('Content-type: application/json', response_code: $code);
        $json = json_encode($data);

        echo $json;
    }
}